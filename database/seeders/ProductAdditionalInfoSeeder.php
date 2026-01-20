<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductAdditionalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Agricultural data templates by category
        $agriculturalData = [
            'sayuran' => [
                'harvest_periods' => [
                    'Januari - Maret',
                    'April - Juni',
                    'Juli - September',
                    'Oktober - Desember',
                    'Sepanjang Tahun (Musim Tanam Bergantian)',
                    'Maret - Juni',
                    'Mei - Agustus',
                ],
                'shelf_lives' => [
                    '3-5 hari di suhu ruang',
                    '7-10 hari di kulkas',
                    '2-3 minggu di kulkas',
                    '5-7 hari di tempat sejuk',
                    '1-2 minggu dalam wadah tertutup',
                    '4-6 hari setelah panen',
                ],
                'organic_statuses' => [
                    'Organik Bersertifikat',
                    'Non-Organik',
                    'Proses Sertifikasi Organik',
                    'Organik Lokal (Tanpa Pestisida)',
                    'Pestisida Rendah',
                    'Pertanian Berkelanjutan',
                ],
                'storage_infos' => [
                    'Simpan di kulkas pada suhu 4-7°C untuk kesegaran maksimal',
                    'Simpan di tempat sejuk dan kering, hindari sinar matahari langsung',
                    'Cuci bersih sebelum disimpan, keringkan dengan handuk bersih',
                    'Jangan dicuci sebelum disimpan, cuci saat akan digunakan',
                    'Simpan dalam wadah tertutup atau plastik berlubang di kulkas',
                    'Pisahkan dari buah-buahan yang mengeluarkan gas etilen',
                    'Simpan di compartment sayuran kulkas dengan kelembaban tinggi',
                ],
            ],
            'buah' => [
                'harvest_periods' => [
                    'Januari - April',
                    'Mei - Agustus',
                    'September - Desember',
                    'Sepanjang Tahun',
                    'Juni - September',
                    'Musim Kemarau (April - Oktober)',
                    'Musim Hujan (November - Maret)',
                ],
                'shelf_lives' => [
                    '5-7 hari di suhu ruang',
                    '2-3 minggu di kulkas',
                    '1-2 minggu di tempat sejuk',
                    '3-5 hari setelah matang sempurna',
                    '7-14 hari tergantung kematangan',
                    '1 minggu di suhu ruang, 3 minggu di kulkas',
                ],
                'organic_statuses' => [
                    'Organik Bersertifikat',
                    'Non-Organik',
                    'Organik Lokal',
                    'Proses Sertifikasi Organik',
                    'Pertanian Ramah Lingkungan',
                ],
                'storage_infos' => [
                    'Simpan di suhu ruang hingga matang, pindahkan ke kulkas setelah matang',
                    'Simpan di kulkas setelah matang untuk memperpanjang kesegaran',
                    'Jangan simpan dekat pisang (mempercepat pematangan)',
                    'Simpan dalam paper bag untuk pematangan bertahap',
                    'Hindari menyimpan dalam plastik tertutup rapat',
                    'Simpan di tempat teduh dengan sirkulasi udara baik',
                ],
            ],
            'rempah' => [
                'harvest_periods' => [
                    'Sepanjang Tahun',
                    'April - Oktober',
                    'Musim Kemarau',
                    'Setelah 6-8 Bulan Tanam',
                ],
                'shelf_lives' => [
                    '6-12 bulan dalam wadah tertutup kedap udara',
                    '3-6 bulan untuk rempah segar',
                    '1-2 tahun untuk rempah kering',
                    '2-3 bulan setelah dibuka',
                ],
                'organic_statuses' => [
                    'Organik Bersertifikat',
                    'Non-Organik',
                    'Organik Tradisional',
                    'Bebas Bahan Kimia',
                ],
                'storage_infos' => [
                    'Simpan di tempat kering, sejuk, dan gelap',
                    'Gunakan wadah kaca atau keramik tertutup rapat',
                    'Hindari paparan sinar matahari langsung dan kelembaban tinggi',
                    'Simpan di suhu ruang, jangan di kulkas',
                ],
            ],
            'beras' => [
                'harvest_periods' => [
                    'Maret - Juni (Musim Panen Utama)',
                    'September - Desember (Musim Panen Kedua)',
                    'Januari - Maret',
                    'Juli - Oktober',
                ],
                'shelf_lives' => [
                    '6-12 bulan dalam wadah tertutup',
                    '3-6 bulan setelah digiling',
                    '1 tahun untuk beras organik',
                    '8-10 bulan di tempat sejuk',
                ],
                'organic_statuses' => [
                    'Organik Bersertifikat',
                    'Non-Organik',
                    'Organik Tradisional',
                    'Sistem Pertanian Terintegrasi',
                ],
                'storage_infos' => [
                    'Simpan di wadah kedap udara di tempat sejuk dan kering',
                    'Hindari kelembaban dan hama dengan tambahkan daun salam atau cabai kering',
                    'Simpan di suhu ruang, jangan di kulkas untuk menjaga tekstur',
                    'Gunakan rice dispenser atau toples kedap udara',
                ],
            ],
        ];

        // Default data for unknown categories
        $defaultData = $agriculturalData['sayuran'];

        // Get all products with category
        $products = Product::with('category')->get();
        $updatedCount = 0;
        $skippedCount = 0;

        $this->command->info("🌾 Starting to populate agricultural data for products...");
        $bar = $this->command->getOutput()->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            // Skip if already has data (idempotent)
            if ($product->harvest_period || $product->shelf_life || $product->organic_status || $product->storage_info) {
                $skippedCount++;
                $bar->advance();
                continue;
            }

            // Determine category and get appropriate data
            $categoryName = strtolower($product->category->name ?? 'default');

            // Match category to data template
            $data = match (true) {
                str_contains($categoryName, 'sayur') || str_contains($categoryName, 'vegetable') => $agriculturalData['sayuran'],
                str_contains($categoryName, 'buah') || str_contains($categoryName, 'fruit') => $agriculturalData['buah'],
                str_contains($categoryName, 'rempah') || str_contains($categoryName, 'spice') || str_contains($categoryName, 'bumbu') => $agriculturalData['rempah'],
                str_contains($categoryName, 'beras') || str_contains($categoryName, 'rice') || str_contains($categoryName, 'padi') => $agriculturalData['beras'],
                default => $defaultData,
            };

            // Update product with random realistic data
            $product->update([
                'harvest_period' => $data['harvest_periods'][array_rand($data['harvest_periods'])],
                'shelf_life' => $data['shelf_lives'][array_rand($data['shelf_lives'])],
                'organic_status' => $data['organic_statuses'][array_rand($data['organic_statuses'])],
                'storage_info' => $data['storage_infos'][array_rand($data['storage_infos'])],
            ]);

            $updatedCount++;
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine(2);

        // Summary
        $this->command->info("✅ Seeding completed successfully!");
        $this->command->newLine();
        $this->command->table(
            ['Metric', 'Count'],
            [
                ['Total Products', $products->count()],
                ['Updated', $updatedCount],
                ['Skipped (already have data)', $skippedCount],
            ]
        );

        if ($updatedCount > 0) {
            $this->command->newLine();
            $this->command->info("🎉 {$updatedCount} products now have complete agricultural information!");
            $this->command->info("📊 Check Admin → Products or visit product details pages to see the data.");
        }

        if ($skippedCount > 0) {
            $this->command->warn("⚠️  {$skippedCount} products were skipped because they already have data.");
            $this->command->info("   To re-seed, clear the fields first or delete and re-run.");
        }
    }
}
