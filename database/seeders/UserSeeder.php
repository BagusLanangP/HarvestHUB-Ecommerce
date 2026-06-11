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
            ['name' => 'Wayan Tani', 'email' => 'wayantani@gmail.com', 'password' => 'password', 'phone' => '+6281234567899', 'alamat' => 'Badung', 'role_id' => 5],
            ['name' => 'Dayuani', 'email' => 'dayuani@gmail.com', 'password' => 'password', 'phone' => '+6282147390098', 'alamat' => 'Gianyar', 'role_id' => 2],
            ['name' => 'Ari savitri', 'email' => 'arisavitri@gmail.com', 'password' => 'password', 'phone' => '+6281999963159', 'alamat' => 'Bangli', 'role_id' => 4],
            ['name' => 'Herdy juniawan', 'email' => 'herdy@gmail.com', 'password' => 'password', 'phone' => '+6281238406922', 'alamat' => 'Bangli', 'role_id' => 4], 
            ['name' => 'Yurika Wahyuning', 'email' => 'yurika@gmail.com', 'password' => 'password', 'phone' => '+6285175311200', 'alamat' => 'Gianyar', 'role_id' => 4],
            ['name' => 'Ketut Wijaya', 'email' => 'ketut@gmail.com', 'password' => 'password', 'phone' => '+6281234567890', 'alamat' => 'Badung', 'role_id' => 3],
            ['name' => 'Wayan Sudiarta', 'email' => 'wayan@gmail.com', 'password' => 'password', 'phone' => '+6281234567891', 'alamat' => 'Klungkung', 'role_id' => 3],
            ['name' => 'Made Sumantra', 'email' => 'made@gmail.com', 'password' => 'password', 'phone' => '+6281234567892', 'alamat' => 'Karangasem', 'role_id' => 3],
            ['name' => 'Nyoman Dharma', 'email' => 'nyoman@gmail.com', 'password' => 'password', 'phone' => '+6281234567893', 'alamat' => 'Denpasar', 'role_id' => 2],
            ['name' => 'Gede Sukra', 'email' => 'gede@gmail.com', 'password' => 'password', 'phone' => '+6281234567894', 'alamat' => 'Buleleng', 'role_id' => 2],
            ['name' => 'Kadek Lestari', 'email' => 'kadek@gmail.com', 'password' => 'password', 'phone' => '+6281234567895', 'alamat' => 'Jembrana', 'role_id' => 2]
        ];

            
        foreach ( $data as $value){
            User::create([
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
