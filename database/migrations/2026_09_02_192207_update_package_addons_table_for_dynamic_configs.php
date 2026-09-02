<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('package_addons', function (Blueprint $table) {
            $table->string('type')->after('package_id')->default('feature'); // os, region, storage, feature
            $table->string('value')->after('name')->nullable();
            $table->boolean('is_global')->after('id')->default(true);
            $table->foreignId('package_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_addons', function (Blueprint $table) {
            $table->dropColumn(['type', 'value', 'is_global']);
            // Reverting package_id requires care if there are nulls. Usually not necessary in down() for this prototype.
            $table->foreignId('package_id')->nullable(false)->change();
        });
    }
};
