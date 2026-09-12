<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Staff / Admin Notes on Users
        Schema::create('user_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('author_name')->default('Admin Staff');
            $table->text('note');
            $table->timestamps();
        });

        // 2. Sent Email Log for Users
        Schema::create('user_email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->string('recipient');
            $table->text('body')->nullable();
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamps();
        });

        // 3. User Activity / Audit Trail
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
        Schema::dropIfExists('user_email_logs');
        Schema::dropIfExists('user_notes');
    }
};
