<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['name' => 'Admin'],
            ['name' => 'user'],
            ['name' => 'Tenaga Kerja'],
            ['name' => 'Ahli Pakar'],
            ['name' => 'Penjual']
        ];

        foreach ( $data as $value){
            Role::insert([
                'name' => $value['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        };


        
    }
}
