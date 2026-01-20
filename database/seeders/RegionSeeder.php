<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            // Jawa Barat
            ['name' => 'Bandung', 'province' => 'Jawa Barat', 'description' => 'Kota Kembang, pusat sayuran dataran tinggi'],
            ['name' => 'Lembang', 'province' => 'Jawa Barat', 'description' => 'Kawasan wisata dan pertanian strawberry'],
            ['name' => 'Garut', 'province' => 'Jawa Barat', 'description' => 'Penghasil sayuran dataran tinggi'],
            ['name' => 'Pangalengan', 'province' => 'Jawa Barat', 'description' => 'Kawasan susu dan sayuran'],
            ['name' => 'Ciwidey', 'province' => 'Jawa Barat', 'description' => 'Penghasil strawberry dan sayuran'],
            ['name' => 'Bogor', 'province' => 'Jawa Barat', 'description' => 'Kota Hujan, penghasil buah-buahan tropis'],
            ['name' => 'Sukabumi', 'province' => 'Jawa Barat', 'description' => 'Penghasil teh dan sayuran'],
            ['name' => 'Cianjur', 'province' => 'Jawa Barat', 'description' => 'Penghasil beras dan sayuran'],

            // Jawa Timur
            ['name' => 'Malang', 'province' => 'Jawa Timur', 'description' => 'Kota Apel, penghasil buah apel dan sayuran'],
            ['name' => 'Batu', 'province' => 'Jawa Timur', 'description' => 'Kota wisata dan pertanian apel'],
            ['name' => 'Pasuruan', 'province' => 'Jawa Timur', 'description' => 'Penghasil buah-buahan tropis'],
            ['name' => 'Ponorogo', 'province' => 'Jawa Timur', 'description' => 'Penghasil jagung dan ubi'],
            ['name' => 'Kediri', 'province' => 'Jawa Timur', 'description' => 'Penghasil tebu dan sayuran'],

            // Jawa Tengah
            ['name' => 'Dieng', 'province' => 'Jawa Tengah', 'description' => 'Dataran tinggi, penghasil kentang dan carica'],
            ['name' => 'Semarang', 'province' => 'Jawa Tengah', 'description' => 'Penghasil sayuran dan buah-buahan'],
            ['name' => 'Wonosobo', 'province' => 'Jawa Tengah', 'description' => 'Penghasil carica dan sayuran'],
            ['name' => 'Temanggung', 'province' => 'Jawa Tengah', 'description' => 'Penghasil tembakau dan sayuran'],
            ['name' => 'Magelang', 'province' => 'Jawa Tengah', 'description' => 'Penghasil salak dan sayuran'],

            // Sumatera Utara
            ['name' => 'Brastagi', 'province' => 'Sumatera Utara', 'description' => 'Dataran tinggi, penghasil sayuran dan buah markisa'],
            ['name' => 'Medan', 'province' => 'Sumatera Utara', 'description' => 'Penghasil durian dan buah tropis'],
            ['name' => 'Sidikalang', 'province' => 'Sumatera Utara', 'description' => 'Penghasil kopi dan jeruk'],

            // Bali
            ['name' => 'Bedugul', 'province' => 'Bali', 'description' => 'Dataran tinggi, penghasil sayuran dan strawberry'],
            ['name' => 'Tabanan', 'province' => 'Bali', 'description' => 'Lumbung padi Bali'],

            // DIY Yogyakarta
            ['name' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'description' => 'Penghasil sayuran dan buah-buahan'],
            ['name' => 'Sleman', 'province' => 'DI Yogyakarta', 'description' => 'Penghasil salak pondoh'],

            // Sumatera Barat
            ['name' => 'Padang', 'province' => 'Sumatera Barat', 'description' => 'Penghasil durian dan rambutan'],
            ['name' => 'Bukittinggi', 'province' => 'Sumatera Barat', 'description' => 'Dataran tinggi, penghasil sayuran'],

            // Lampung
            ['name' => 'Bandar Lampung', 'province' => 'Lampung', 'description' => 'Penghasil nanas dan pisang'],

            // Kalimantan
            ['name' => 'Pontianak', 'province' => 'Kalimantan Barat', 'description' => 'Penghasil durian dan jeruk'],
            ['name' => 'Samarinda', 'province' => 'Kalimantan Timur', 'description' => 'Penghasil buah-buahan tropis'],

            // Sulawesi
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan', 'description' => 'Penghasil pisang dan sayuran'],
            ['name' => 'Toraja', 'province' => 'Sulawesi Selatan', 'description' => 'Penghasil kopi arabika'],
        ];

        foreach ($regions as $region) {
            DB::table('regions')->insert([
                'name' => $region['name'],
                'slug' => Str::slug($region['name']),
                'province' => $region['province'],
                'description' => $region['description'],
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
