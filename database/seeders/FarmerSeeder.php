<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Farmer;
use App\Models\Region;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get regions untuk associate dengan farmers
        $bandung = Region::where('name', 'Bandung')->first();
        $lembang = Region::where('name', 'Lembang')->first();
        $malang = Region::where('name', 'Malang')->first();
        $batu = Region::where('name', 'Batu')->first();
        $bogor = Region::where('name', 'Bogor')->first();
        $dieng = Region::where('name', 'Dieng')->first();

        $farmers = [
            [
                'name' => 'Pak Budi Santoso',
                'slug' => 'pak-budi-santoso',
                'email' => 'budi.santoso@example.com',
                'phone' => '081234567890',
                'location' => 'Desa Cibodas, Lembang',
                'region_id' => $lembang?->id,
                'description' => 'Petani sayuran organik dengan pengalaman 15 tahun. Spesialisasi dalam budidaya sayuran daun dan strawberry.',
                'certification' => 'Organik',
                'is_active' => true,
            ],
            [
                'name' => 'Kelompok Tani Maju Bersama',
                'slug' => 'kelompok-tani-maju-bersama',
                'email' => 'majubersama@example.com',
                'phone' => '081234567891',
                'location' => 'Kecamatan Ciwidey, Bandung',
                'region_id' => $bandung?->id,
                'description' => 'Kelompok tani dengan 50+ anggota yang fokus pada pertanian berkelanjutan dan ramah lingkungan.',
                'certification' => 'Non-GMO',
                'is_active' => true,
            ],
            [
                'name' => 'Bu Siti Rahayu',
                'slug' => 'bu-siti-rahayu',
                'email' => 'siti.rahayu@example.com',
                'phone' => '081234567892',
                'location' => 'Desa Sidomulyo, Batu',
                'region_id' => $batu?->id,
                'description' => 'Petani buah apel dan strawberry. Menggunakan metode pertanian alami tanpa pestisida kimia.',
                'certification' => 'Organik',
                'is_active' => true,
            ],
            [
                'name' => 'Pak Joko Widodo',
                'slug' => 'pak-joko-widodo',
                'email' => 'joko.widodo@example.com',
                'phone' => '081234567893',
                'location' => 'Kecamatan Karangploso, Malang',
                'region_id' => $malang?->id,
                'description' => 'Petani sayuran hidroponik modern. Menghasilkan sayuran segar berkualitas tinggi sepanjang tahun.',
                'certification' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Kelompok Tani Berkah',
                'slug' => 'kelompok-tani-berkah',
                'email' => 'berkah@example.com',
                'phone' => '081234567894',
                'location' => 'Desa Tawangmangu, Dieng',
                'region_id' => $dieng?->id,
                'description' => 'Petani kentang dan carica khas Dieng. Memanfaatkan iklim sejuk pegunungan untuk hasil berkualitas.',
                'certification' => 'GAP Certified',
                'is_active' => true,
            ],
            [
                'name' => 'Pak Ahmad Dahlan',
                'slug' => 'pak-ahmad-dahlan',
                'email' => 'ahmad.dahlan@example.com',
                'phone' => '081234567895',
                'location' => 'Kecamatan Cisarua, Bogor',
                'region_id' => $bogor?->id,
                'description' => 'Spesialis tanaman hias dan sayuran organik. Menerapkan sistem pertanian terpadu.',
                'certification' => 'Organik',
                'is_active' => true,
            ],
        ];

        foreach ($farmers as $farmer) {
            Farmer::create($farmer);
        }
    }
}
