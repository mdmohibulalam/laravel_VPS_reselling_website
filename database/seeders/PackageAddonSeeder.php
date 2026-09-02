<?php

namespace Database\Seeders;

use App\Models\PackageAddon;
use Illuminate\Database\Seeder;

class PackageAddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addons = [
            // OS
            ['type' => 'os', 'name' => 'Ubuntu 24.04 LTS', 'value' => 'ubuntu_24_04', 'price' => 0.00],
            ['type' => 'os', 'name' => 'Debian 12', 'value' => 'debian_12', 'price' => 0.00],
            ['type' => 'os', 'name' => 'AlmaLinux 9', 'value' => 'almalinux_9', 'price' => 0.00],
            ['type' => 'os', 'name' => 'Rocky Linux 9', 'value' => 'rocky_9', 'price' => 0.00],
            ['type' => 'os', 'name' => 'Windows Server 2022', 'value' => 'win_2022', 'price' => 7.00],

            // Regions
            ['type' => 'region', 'name' => 'US East (New York)', 'value' => 'us_east', 'price' => 1.50],
            ['type' => 'region', 'name' => 'US West (Seattle)', 'value' => 'us_west', 'price' => 1.50],
            ['type' => 'region', 'name' => 'EU Central (Germany)', 'value' => 'eu_central', 'price' => 0.00],
            ['type' => 'region', 'name' => 'UK (London)', 'value' => 'uk_london', 'price' => 0.00],
            ['type' => 'region', 'name' => 'Asia (Singapore)', 'value' => 'asia_singapore', 'price' => 2.50],
            ['type' => 'region', 'name' => 'Australia (Sydney)', 'value' => 'au_sydney', 'price' => 3.00],

            // Storage
            ['type' => 'storage', 'name' => '100 GB NVMe', 'value' => '100GB', 'price' => 0.00],
            ['type' => 'storage', 'name' => '200 GB NVMe', 'value' => '200GB', 'price' => 1.80],
            ['type' => 'storage', 'name' => '400 GB NVMe', 'value' => '400GB', 'price' => 3.60],

            // Features (Backups)
            ['type' => 'backup', 'name' => 'No Data Protection', 'value' => '0', 'price' => 0.00],
            ['type' => 'backup', 'name' => 'Auto Backup', 'value' => '1', 'price' => 1.95],

            // Features (Networking)
            ['type' => 'network', 'name' => 'No Private Networking', 'value' => '0', 'price' => 0.00],
            ['type' => 'network', 'name' => 'Private Networking Enabled', 'value' => '1', 'price' => 2.75],
        ];

        foreach ($addons as $addon) {
            PackageAddon::updateOrCreate(
                ['type' => $addon['type'], 'value' => $addon['value']],
                [
                    'name' => $addon['name'],
                    'price' => $addon['price'],
                    'is_global' => true,
                    'package_id' => null,
                    'billing_cycle' => 'monthly',
                ]
            );
        }
    }
}
