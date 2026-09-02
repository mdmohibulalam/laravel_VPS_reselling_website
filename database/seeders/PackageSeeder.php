<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Cloud VPS 4',
                'description' => 'Great value VPS for getting started.',
                'category' => 'vps',
                'specs' => [
                    'Cores' => '4 vCPU Cores',
                    'Memory' => '8 GB RAM',
                    'Storage' => '100 GB SSD',
                    'Snapshots' => '1 Snapshot',
                    'Port Speeds' => '200 Mbit/s Port',
                    'Traffic' => 'Unlimited Traffic*'
                ],
                'price_monthly' => 6.60,
                'price_quarterly' => 19.80,
                'price_semi_annually' => 39.60,
                'price_annually' => 67.32, // 15% off
                'setup_fee' => 0.00,
                'is_active' => true,
            ],
            [
                'name' => 'Cloud VPS 6',
                'description' => 'Balanced performance for growing sites.',
                'category' => 'vps',
                'specs' => [
                    'Cores' => '6 vCPU Cores',
                    'Memory' => '12 GB RAM',
                    'Storage' => '200 GB SSD',
                    'Snapshots' => '2 Snapshots',
                    'Port Speeds' => '300 Mbit/s Port',
                    'Traffic' => 'Unlimited Traffic*'
                ],
                'price_monthly' => 9.00,
                'price_quarterly' => 27.00,
                'price_semi_annually' => 54.00,
                'price_annually' => 91.80, // 15% off
                'setup_fee' => 0.00,
                'is_active' => true,
            ],
            [
                'name' => 'Cloud VPS 8',
                'description' => 'High performance for demanding applications.',
                'category' => 'vps',
                'specs' => [
                    'Cores' => '8 vCPU Cores',
                    'Memory' => '24 GB RAM',
                    'Storage' => '300 GB SSD',
                    'Snapshots' => '3 Snapshots',
                    'Port Speeds' => '600 Mbit/s Port',
                    'Traffic' => 'Unlimited Traffic*'
                ],
                'price_monthly' => 16.80,
                'price_quarterly' => 50.40,
                'price_semi_annually' => 100.80,
                'price_annually' => 171.36, // 15% off
                'setup_fee' => 0.00,
                'is_active' => true,
            ],
            [
                'name' => 'Cloud VPS 12',
                'description' => 'Enterprise-grade resources for professionals.',
                'category' => 'vps',
                'specs' => [
                    'Cores' => '12 vCPU Cores',
                    'Memory' => '48 GB RAM',
                    'Storage' => '400 GB SSD',
                    'Snapshots' => '3 Snapshots',
                    'Port Speeds' => '800 Mbit/s Port',
                    'Traffic' => 'Unlimited Traffic*'
                ],
                'price_monthly' => 30.00,
                'price_quarterly' => 90.00,
                'price_semi_annually' => 180.00,
                'price_annually' => 306.00, // 15% off
                'setup_fee' => 0.00,
                'is_active' => true,
            ],
            [
                'name' => 'Cloud VPS 16',
                'description' => 'Massive resources for large scale projects.',
                'category' => 'vps',
                'specs' => [
                    'Cores' => '16 vCPU Cores',
                    'Memory' => '64 GB RAM',
                    'Storage' => '500 GB SSD',
                    'Snapshots' => '3 Snapshots',
                    'Port Speeds' => '1 Gbit/s Port',
                    'Traffic' => 'Unlimited Traffic*'
                ],
                'price_monthly' => 44.50,
                'price_quarterly' => 133.50,
                'price_semi_annually' => 267.00,
                'price_annually' => 453.90, // 15% off
                'setup_fee' => 0.00,
                'is_active' => true,
            ],
            [
                'name' => 'Cloud VPS 18',
                'description' => 'Ultimate performance for extreme workloads.',
                'category' => 'vps',
                'specs' => [
                    'Cores' => '18 vCPU Cores',
                    'Memory' => '96 GB RAM',
                    'Storage' => '600 GB SSD',
                    'Snapshots' => '3 Snapshots',
                    'Port Speeds' => '1 Gbit/s Port',
                    'Traffic' => 'Unlimited Traffic*'
                ],
                'price_monthly' => 58.80,
                'price_quarterly' => 176.40,
                'price_semi_annually' => 352.80,
                'price_annually' => 599.76, // 15% off
                'setup_fee' => 0.00,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            \App\Models\Package::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
