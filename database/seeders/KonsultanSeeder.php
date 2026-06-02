<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konsultan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class KonsultanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Konsultan::truncate();
        Schema::enableForeignKeyConstraints();

        // Get users with role 4 (Ahli Pakar / Konsultan)
        $experts = User::where('role_id', 4)->get();

        $expertises = [
            'Budi Doremi' => [
                'keahlian' => 'Konsultan Pemuliaan Tanaman',
                'pengalaman' => '5 Tahun Penelitian Pemuliaan Benih padi dan Jagung Hibrida',
                'deskripsi' => 'Ahli dalam rekayasa varietas benih unggul, teknik silang tanaman pangan, dan peningkatan produktivitas lahan sempit.',
            ],
            'Ari savitri' => [
                'keahlian' => 'Ahli Fitopatologi (Penyakit Tanaman)',
                'pengalaman' => '4 Tahun Konsultan Pengendalian Hama Organik',
                'deskripsi' => 'Spesialis diagnosis dini penyakit daun, analisis jamur tanah, dan pembuatan biopestisida ramah lingkungan.',
            ],
            'Herdy juniawan' => [
                'keahlian' => 'Spesialis Hidroponik & Greenhouse',
                'pengalaman' => '6 Tahun Pemasangan & Maintenance Greenhouse Modern',
                'deskripsi' => 'Pakar sistem irigasi fertigasi otomatis, formulasi nutrisi AB Mix khusus buah sayur, dan optimasi suhu greenhouse.',
            ],
            'Yurika Wahyuning' => [
                'keahlian' => 'Konsultan Manajemen Agribisnis',
                'pengalaman' => '5 Tahun Pembinaan Kelompok Tani & Kelayakan Usaha',
                'deskripsi' => 'Ahli dalam perencanaan keuangan perkebunan, sertifikasi organik nasional, dan pemasaran produk tani digital.',
            ]
        ];

        foreach ($experts as $expert) {
            $details = $expertises[$expert->name] ?? [
                'keahlian' => 'Konsultan Pertanian Umum',
                'pengalaman' => '3 Tahun Pendampingan Kelompok Tani',
                'deskripsi' => 'Membantu petani mengoptimalkan hasil panen melalui pemupukan presisi dan rotasi tanaman.',
            ];

            Konsultan::create([
                'user_id' => $expert->id,
                'nama' => $expert->name,
                'email' => $expert->email,
                'phone' => $expert->phone,
                'alamat' => $expert->alamat,
                'keahlian' => $details['keahlian'],
                'pengalaman' => $details['pengalaman'],
                'deskripsi' => $details['deskripsi'],
                'foto' => 'default-avatar.png',
                'foto_cv' => null,
            ]);
        }
    }
}
