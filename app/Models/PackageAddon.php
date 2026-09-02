<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id', 'is_global', 'type', 'name', 'value', 'price', 'billing_cycle'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_global' => 'boolean',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function scopeGlobal($query)
    {
        return $query->where('is_global', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
