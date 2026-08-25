<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Order;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function show(Package $package)
    {
        return view('checkout', compact('package'));
    }

    public function process(Request $request, Package $package)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'payment_type' => 'required|in:stripe,manual',
            'payment_method_id' => 'required_if:payment_type,stripe|nullable|string',
            'password' => 'required_without:is_logged_in|string|min:8',
        ]);

        $user = Auth::user();

        if (!$user) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                // If user exists but not logged in, error
                return back()->withErrors(['email' => 'An account with this email exists. Please login first.']);
            }
            
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            Auth::login($user);
        }

        if ($request->payment_type === 'stripe') {
            $stripe = new StripeClient(config('services.stripe.secret'));
            
            try {
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $package->price_monthly * 100, // in cents
                    'currency' => 'usd',
                    'payment_method' => $request->payment_method_id,
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],
                ]);
                
                if ($paymentIntent->status !== 'succeeded') {
                    return back()->withErrors(['error' => 'Payment failed or requires additional action.']);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['error' => $e->getMessage()]);
            }
        }

        // Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $package->price_monthly,
            'status' => 'pending',
        ]);
        
        // Create Invoice
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount' => $package->price_monthly,
            'tax' => 0,
            'total' => $package->price_monthly,
            'status' => $request->payment_type === 'stripe' ? 'paid' : 'pending',
            'stripe_payment_intent_id' => $paymentIntent->id ?? null,
            'due_date' => $request->payment_type === 'stripe' ? null : now()->addDays(7),
            'paid_at' => $request->payment_type === 'stripe' ? now() : null,
        ]);
        
        // Create Service
        Service::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'package_id' => $package->id,
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'next_due_date' => now()->addMonth(),
        ]);
        
        $message = $request->payment_type === 'stripe' 
            ? 'Order placed successfully! It will be provisioned shortly.' 
            : 'Order received! Please complete your manual payment. We will provision your service once confirmed.';
            
        return redirect('/customer')->with('success', $message);
    }
}
