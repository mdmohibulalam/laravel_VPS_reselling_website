<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Resolve the location string with country flag and network indicators.
     */
    public function getLocationAttribute(): string
    {
        $ip = $this->ip_address;
        $user = $this->user;

        $country = $user?->country ?? '';
        $city = $user?->city ?? '';
        $profileParts = array_filter([$city, $country]);
        $profileLocation = implode(', ', $profileParts);
        $flag = $this->country_flag;

        if (empty($ip) || $ip === '-') {
            return $profileLocation ? "{$flag} {$profileLocation}" : 'Unknown Location';
        }

        // Check if IP is in a private, loopback, or reserved range
        $isPrivate = !filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );

        if ($isPrivate) {
            if ($profileLocation) {
                return "{$flag} {$profileLocation} (LAN)";
            }
            return 'Local Network (Private IP)';
        }

        // For public IPs, cache lookup for 7 days to avoid repeated network latency
        return Cache::remember("geoip_{$ip}", 86400 * 7, function () use ($ip, $flag, $profileLocation) {
            try {
                $ctx = stream_context_create(['http' => ['timeout' => 2]]);
                $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,countryCode", false, $ctx);
                if ($json) {
                    $data = json_decode($json, true);
                    if (($data['status'] ?? '') === 'success') {
                        $c = $data['country'] ?? '';
                        $ci = $data['city'] ?? '';
                        $resolved = implode(', ', array_filter([$ci, $c]));
                        $code = strtolower($data['countryCode'] ?? '');
                        $ipFlag = self::resolveCountryFlag($code);
                        if ($resolved) {
                            return "{$ipFlag} {$resolved}";
                        }
                    }
                }
            } catch (\Throwable $e) {}

            return $profileLocation ? "{$flag} {$profileLocation}" : 'Global / Unknown';
        });
    }

    /**
     * Resolve a country name or ISO code to its corresponding vector emoji flag.
     */
    public static function resolveCountryFlag(?string $countryOrCode): string
    {
        if (empty($countryOrCode)) {
            return '🌐';
        }
        $c = strtolower(trim($countryOrCode));

        return match (true) {
            $c === 'us' || str_contains($c, 'united states') => '🇺🇸',
            $c === 'gb' || $c === 'uk' || str_contains($c, 'united kingdom') => '🇬🇧',
            $c === 'de' || str_contains($c, 'germany') => '🇩🇪',
            $c === 'ca' || str_contains($c, 'canada') => '🇨🇦',
            $c === 'fr' || str_contains($c, 'france') => '🇫🇷',
            $c === 'sg' || str_contains($c, 'singapore') => '🇸🇬',
            $c === 'nl' || str_contains($c, 'netherlands') => '🇳🇱',
            $c === 'au' || str_contains($c, 'australia') => '🇦🇺',
            $c === 'in' || str_contains($c, 'india') => '🇮🇳',
            $c === 'bd' || str_contains($c, 'bangladesh') => '🇧🇩',
            $c === 'jp' || str_contains($c, 'japan') => '🇯🇵',
            $c === 'es' || str_contains($c, 'spain') => '🇪🇸',
            $c === 'it' || str_contains($c, 'italy') => '🇮🇹',
            $c === 'br' || str_contains($c, 'brazil') => '🇧🇷',
            default => '🌐',
        };
    }

    public function getCountryFlagAttribute(): string
    {
        return self::resolveCountryFlag($this->user?->country);
    }
}
