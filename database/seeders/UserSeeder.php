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
            ['name' => 'Lanang Purbhawa', 'email' => 'baguslanangpurbhawa@gmail.com', 'password' => 'password', 'phone' => '+6282145149616', 'alamat' => 'Gianyar', 'role_id' => 1, ],
            ['name' => 'Dewa', 'email' => 'dewa@gmail.com', 'password' => 'password', 'phone' => '+62858581582', 'alamat' => 'Tabanan', 'role_id' => 1],
            ['name' => 'Mardana', 'email' => 'Mardana@gmail.com', 'password' => 'password', 'phone' => '085858158622', 'alamat' => 'Tabanan', 'role_id' => 2],
            ['name' => 'alex', 'email' => 'alexsancez101@gmail.com', 'password' => 'password', 'phone' => '+62858581056', 'alamat' => 'Tabanan', 'role_id' => 3],
            ['name' => 'Budi Doremi', 'email' => 'budi@gmail.com', 'password' => 'password', 'phone' => '+62858581588', 'alamat' => 'Tabanan', 'role_id' => 4],         
            ['name' => 'Steven', 'email' => 'steven@gmail.com', 'password' => 'password', 'phone' => '+62858581581', 'alamat' => 'Tabanan', 'role_id' => 5],
            ['name' => 'Adi Suryadi', 'email' => 'adi_s@gmail.com', 'password' => 'password', 'phone' => '+6285173183558', 'alamat' => 'Gianyar', 'role_id' => 5],
            ['name' => 'Dayuani', 'email' => 'dayuani@gmail.com', 'password' => 'password', 'phone' => '+6282147390098', 'alamat' => 'Gianyar', 'role_id' => 2],
            ['name' => 'Ari savitri', 'email' => 'arisavitri@gmail.com', 'password' => 'password', 'phone' => '+6281999963159', 'alamat' => 'Bangli', 'role_id' => 4],
            ['name' => 'Herdy juniawan', 'email' => 'herdy@gmail.com', 'password' => 'password', 'phone' => '+6281238406922', 'alamat' => 'Bangli', 'role_id' => 4], 
            ['name' => 'Yurika Wahyuning', 'email' => 'yurika@gmail.com', 'password' => 'password', 'phone' => '+6285175311200', 'alamat' => 'Gianyar', 'role_id' => 4]        
        ];

            
        foreach ( $data as $value){
            User::insert([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => bcrypt($value['password']),
                'phone' => $value['phone'],
                'alamat' => $value['alamat'],
                'role_id' => $value['role_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        };





    
    }
}
