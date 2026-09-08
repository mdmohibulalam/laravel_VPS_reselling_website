<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specs' => 'array',
            'is_active' => 'boolean',
            'price_monthly' => 'decimal:2',
            'price_quarterly' => 'decimal:2',
            'price_semi_annually' => 'decimal:2',
            'price_annually' => 'decimal:2',
            'setup_fee' => 'decimal:2',
        ];
    }

    public function addons(): HasMany
    {
        return $this->hasMany(PackageAddon::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Retrieve active packages cached for 24 hours.
     */
    public static function getCachedActivePackages(): \Illuminate\Database\Eloquent\Collection
    {
        return \Illuminate\Support\Facades\Cache::remember('catalog:packages:active', 86400, function () {
            return static::where('is_active', true)->orderBy('price_monthly')->get();
        });
    }

    /**
     * The "booted" method of the model to handle automatic cache invalidation.
     */
    protected static function booted(): void
    {
        static::saved(function ($package) {
            static::clearCatalogCache($package->id);
        });

        static::deleted(function ($package) {
            static::clearCatalogCache($package->id);
        });
    }

    /**
     * Purge all related catalog cache entries.
     */
    public static function clearCatalogCache(?int $packageId = null): void
    {
        \Illuminate\Support\Facades\Cache::forget('catalog:packages:active');
        \Illuminate\Support\Facades\Cache::forget('catalog:sitemap_xml');
        if ($packageId) {
            \Illuminate\Support\Facades\Cache::forget("catalog:addons:package_{$packageId}");
        }
    }
}

