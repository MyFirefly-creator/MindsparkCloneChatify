<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_pelanggarans')->insert([
            ['jenis_pelanggaran' => 'Terlambat mengembalikan buku', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_pelanggaran' => 'Merusak atau mencoret buku', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_pelanggaran' => 'Hilang atau tidak mengembalikan buku', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_pelanggaran' => 'Menggunakan kartu anggota orang lain', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_pelanggaran' => 'Membuat kegaduhan di perpustakaan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
