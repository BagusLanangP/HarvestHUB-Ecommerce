<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['name' => 'Lanang Purbhawa', 'email' => 'baguslanangpurbhawa@gmail.com', 'password' => '200603', 'phone' => '082145149616', 'alamat' => 'Gianyar', 'role_id' => 1, ],
            ['name' => 'Mardana', 'email' => 'Mardana@gmail.com', 'password' => '12345678', 'phone' => '085858158622', 'alamat' => 'Tabanan', 'role_id' => 1, ]           
        ];

        foreach ( $data as $value){
            User::insert([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => $value['password'],
                'phone' => $value['phone'],
                'alamat' => $value['alamat'],
                'role_id' => $value['role_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        };





    
    }
}
