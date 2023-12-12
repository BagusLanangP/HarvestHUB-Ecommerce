<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TenagaKerja;
use Carbon\Carbon;

class TenagaKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'pengalaman' => 'hehehehe saya tidak punya pengalaman',
                'deskripsi' => 'saya manusia, bukan robot atau alien',
            ],

            [  
                'user_id' => 2,
                'pengalaman' => 'Info loker, pengalaman terakir kerja bakti',
                'deskripsi' => 'gaaaak adaaa, privasi',
            ]           
        ];

        foreach ( $data as $value){
            TenagaKerja::insert([
                'user_id' =>  $value['user_id'],
                'pengalaman' => $value['pengalaman'],
                'deskripsi' => $value['deskripsi'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                
            ]);
        };
    }
}
