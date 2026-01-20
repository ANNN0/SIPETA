<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $productTypes = [
            [
                'name' => 'Segar',
                'slug' => 'fresh',
                'description' => 'Produk segar hasil panen langsung dari petani',
                'icon' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 9l-5 5-5-5"/></svg>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Kering',
                'slug' => 'dry',
                'description' => 'Produk yang telah dikeringkan untuk penyimpanan lebih lama',
                'icon' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Olahan',
                'slug' => 'processed',
                'description' => 'Produk yang telah diolah atau diproses',
                'icon' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Benih/Bibit',
                'slug' => 'seed',
                'description' => 'Benih atau bibit tanaman untuk budidaya',
                'icon' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="12" r="7"/></svg>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tanaman Hidup',
                'slug' => 'live-plant',
                'description' => 'Tanaman dalam kondisi hidup siap tanam',
                'icon' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 10c.7-.7 1.69 0 2.5 0a2.5 2.5 0 1 0 0-5 .5 .5 0 0 1-.5-.5 2.5 2.5 0 1 0-5 0c0 .81.7 1.8 0 2.5l-7 7c-.7.7-1.69 0-2.5 0a2.5 2.5 0 0 0 0 5c.28 0 .5.22.5.5a2.5 2.5 0 1 0 5 0c0-.81-.7-1.8 0-2.5l7-7z"/></svg>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Grosir/Partai Besar',
                'slug' => 'bulk',
                'description' => 'Pembelian dalam jumlah besar dengan harga khusus',
                'icon' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tanaman Herbal',
                'slug' => 'herbal-plants',
                'description' => 'Tanaman herbal dan obat-obatan tradisional',
                'icon' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6.5 12c0-1 .34-2 1-3A7 7 0 0 1 14 3c-1.76 1.26-2.5 3.5-2.5 5.5 0 1.72.5 3.5 2 6l1.5 3"/><path d="M17.5 12c0 1-.34 2-1 3a7 7 0 0 1-6.5 6c1.76-1.26 2.5-3.5 2.5-5.5 0-1.72-.5-3.5-2-6L9 6.5"/></svg>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('product_types')->insert($productTypes);
    }
}
