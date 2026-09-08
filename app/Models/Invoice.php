<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
            'due_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = static::generateNextNumber();
            }
        });
    }

    /**
     * Generate a clean, sequential, and easily understandable invoice number (e.g., INV-10001, INV-10002).
     */
    public static function generateNextNumber(): string
    {
        $invoices = static::query()
            ->where('invoice_number', 'LIKE', 'INV-%')
            ->orderByDesc('id')
            ->limit(30)
            ->get();

        $maxNumber = 10000;
        foreach ($invoices as $inv) {
            if (preg_match('/^INV-(\d+)$/', $inv->invoice_number, $matches)) {
                $num = intval($matches[1]);
                if ($num > $maxNumber) {
                    $maxNumber = $num;
                }
            }
        }

        if ($maxNumber === 10000) {
            $maxId = static::max('id') ?? 0;
            $nextSeq = 10000 + $maxId + 1;
        } else {
            $nextSeq = $maxNumber + 1;
        }

        while (static::where('invoice_number', 'INV-' . $nextSeq)->exists()) {
            $nextSeq++;
        }

        return 'INV-' . $nextSeq;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
