<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TenagaKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class TenagaKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TenagaKerja::truncate();
        Schema::enableForeignKeyConstraints();

        // Get users with role 3 (Tenaga Kerja)
        $workers = User::where('role_id', 3)->get();

        $workerDetails = [
            'alex' => [
                'keahlian' => 'Tenaga Pengolah Lahan',
                'pengalaman' => '3 Tahun Pengolahan Lahan Hortikultura dan Irigasi Tetes',
                'deskripsi' => 'Tenaga kerja ahli dalam mengolah tanah, penanaman sayur, pemupukan organik, dan pemasangan sistem irigasi modern.',
                'foto' => 'konsultan-foto/pekerjalaki.jpg',
            ],
            'Ketut Wijaya' => [
                'keahlian' => 'Pemeliharaan & Pemupukan',
                'pengalaman' => '4 Tahun Pemeliharaan Tanaman Pangan & Hortikultura',
                'deskripsi' => 'Spesialis pemeliharaan tanaman, penyiangan gulma, pemangkasan rutin, serta formulasi dan aplikasi pupuk organik secara presisi.',
                'foto' => 'konsultan-foto/konsultanlaki.jpg',
            ],
            'Wayan Sudiarta' => [
                'keahlian' => 'Pemanenan & Sortasi (Pasca Panen)',
                'pengalaman' => '5 Tahun Penanganan Pasca Panen Komoditas Sayur',
                'deskripsi' => 'Terampil melakukan pemanenan dengan metode yang tepat, sortasi standar kualitas supermarket, pengemasan higienis, dan manajemen distribusi.',
                'foto' => 'konsultan-foto/konsultanlaki2.jpg',
            ],
            'Made Sumantra' => [
                'keahlian' => 'Operator Alat & Mesin Pertanian (Alsintan)',
                'pengalaman' => '3 Tahun Operator Traktor Roda 4 & Drone Sprayer',
                'deskripsi' => 'Ahli mengoperasikan dan merawat berbagai alsintan modern seperti hand tractor, traktor roda empat, mesin pemupukan otomatis, dan drone penyemprot hama.',
                'foto' => 'konsultan-foto/konsultanlaki3.jpg',
            ],
        ];

        foreach ($workers as $worker) {
            $details = $workerDetails[$worker->name] ?? [
                'keahlian' => 'Tenaga Kerja Pertanian Umum',
                'pengalaman' => '2 Tahun Pekerja Lapangan Kebun Hortikultura',
                'deskripsi' => 'Membantu persiapan lahan, penanaman, penyiraman, dan panen komoditas sayuran atau buah.',
                'foto' => 'konsultan-foto/pekerjalaki.jpg',
            ];

            TenagaKerja::create([
                'user_id' => $worker->id,
                'nama' => $worker->name,
                'email' => $worker->email,
                'phone' => $worker->phone,
                'alamat' => $worker->alamat,
                'keahlian' => $details['keahlian'],
                'pengalaman' => $details['pengalaman'],
                'deskripsi' => $details['deskripsi'],
                'foto' => $details['foto'],
                'foto_cv' => null,
            ]);
        }
    }
}
