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

        foreach ($workers as $worker) {
            TenagaKerja::create([
                'user_id' => $worker->id,
                'nama' => $worker->name,
                'email' => $worker->email,
                'phone' => $worker->phone,
                'alamat' => $worker->alamat,
                'keahlian' => 'Tenaga Pengolah Lahan',
                'pengalaman' => '3 Tahun Pengolahan Lahan Hortikultura dan Irigasi Tetes',
                'deskripsi' => 'Tenaga kerja ahli dalam mengolah tanah, penanaman sayur, pemupukan organik, dan pemasangan sistem irigasi modern.',
                'foto' => 'default-avatar.png',
                'foto_cv' => null,
            ]);
        }
    }
}
