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
            ['name' => 'Lanang Purbhawa', 'email' => 'baguslanangpurbhawa@gmail.com', 'password' => '$2y$12$JgpU1XYcPRcIxjlqoae11.Bye26S34GgHUdlUte/Y3zpbYz0TRfLO', 'phone' => '+6282145149616', 'alamat' => 'Gianyar', 'role_id' => 1, ],
            ['name' => 'Dewa', 'email' => 'dewa@gmail.com', 'password' => '$2y$12$JgpU1XYcPRcIxjlqoae11.Bye26S34GgHUdlUte/Y3zpbYz0TRfLO', 'phone' => '+62858581582', 'alamat' => 'Tabanan', 'role_id' => 1],
            ['name' => 'Mardana', 'email' => 'Mardana@gmail.com', 'password' => '$2y$12$IuYi/gGl/pWkWLXc9iXmueP8Zm8bs6Q8NwfUxFZLKuYJDtZk61052', 'phone' => '085858158622', 'alamat' => 'Tabanan', 'role_id' => 2],
            ['name' => 'alex', 'email' => 'alexsancez101@gmail.com', 'password' => '$2y$12$79zH32tfk54WNB3Uq9fGtOL.r1.6Y.JayplNd4imShD0xJwDHUxSG', 'phone' => '+62858581056', 'alamat' => 'Tabanan', 'role_id' => 3],
            ['name' => 'Budi Doremi', 'email' => 'budi@gmail.com', 'password' => '$2y$12$QY12G/bzhIX.R1QM7zpAhumdo79AF/EaKmjSlZdNz2ZEQ3KN486ay', 'phone' => '+62858581588', 'alamat' => 'Tabanan', 'role_id' => 4],         
            ['name' => 'Steven', 'email' => 'steven@gmail.com', 'password' => '$2y$12$oev9zfvS5wNCUlLyc6Igc.8rqJigQ0buKzWi9PdA61ucfAuxvqf2C', 'phone' => '+62858581581', 'alamat' => 'Tabanan', 'role_id' => 5],
            ['name' => 'Adi Suryadi', 'email' => 'adi_s@gmail.com', 'password' => '$2y$12$oev9zfvS5wNCUlLyc6Igc.8rqJigQ0buKzWi9PdA61ucfAuxvqf2C', 'phone' => '+6285173183558', 'alamat' => 'Gianyar', 'role_id' => 5],
            ['name' => 'Dayuani', 'email' => 'dayuani@gmail.com', 'password' => '$2y$12$JgpU1XYcPRcIxjlqoae11.Bye26S34GgHUdlUte/Y3zpbYz0TRfLO', 'phone' => '+6282147390098', 'alamat' => 'Gianyar', 'role_id' => 2],
            ['name' => 'Ari savitri', 'email' => 'arisavitri@gmail.com', 'password' => '$2y$12$JgpU1XYcPRcIxjlqoae11.Bye26S34GgHUdlUte/Y3zpbYz0TRfLO', 'phone' => '+6281999963159', 'alamat' => 'Bangli', 'role_id' => 4],
            ['name' => 'Herdy juniawan', 'email' => 'herdy@gmail.com', 'password' => '$2y$12$JgpU1XYcPRcIxjlqoae11.Bye26S34GgHUdlUte/Y3zpbYz0TRfLO', 'phone' => '+6281238406922', 'alamat' => 'Bangli', 'role_id' => 4], 
            ['name' => 'Yurika Wahyuning', 'email' => 'yurika@gmail.com', 'password' => '$2y$12$JgpU1XYcPRcIxjlqoae11.Bye26S34GgHUdlUte/Y3zpbYz0TRfLO', 'phone' => '+6285175311200', 'alamat' => 'Gianyar', 'role_id' => 4]        
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
