<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'is_global',
        'is_out_of_stock',
        'is_enabled',
        'sort_order',
        'type',
        'category',
        'name',
        'value',
        'api_identifier',
        'price',
        'billing_cycle',
    ];

    protected $appends = ['os_family'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_global' => 'boolean',
            'is_out_of_stock' => 'boolean',
            'is_enabled' => 'boolean',
            'sort_order' => 'integer',
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

    public function scopeAvailable($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('is_out_of_stock', false);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getOsFamilyAttribute(): string
    {
        if (!empty($this->category)) {
            return strtolower($this->category);
        }

        $needle = strtolower($this->name . ' ' . $this->value);
        if (str_contains($needle, 'ubuntu')) {
            return 'ubuntu';
        }
        if (str_contains($needle, 'debian')) {
            return 'debian';
        }
        if (str_contains($needle, 'almalinux') || str_contains($needle, 'rocky') || str_contains($needle, 'centos') || str_contains($needle, 'rhel')) {
            return 'rhel';
        }
        if (str_contains($needle, 'windows') || str_contains($needle, 'win')) {
            return 'windows';
        }

        return 'other';
    }
}
