<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProductCategory::truncate();
        Schema::enableForeignKeyConstraints();
        //

        $data = [
            ['productName' => 'Sayur', 'foto' => 'sayur.png'],
            ['productName' => 'Buah', 'foto' => 'buah.png'],
            ['productName' => 'Hewani', 'foto' => 'hewani.png'],
            ['productName' => 'Obat dan pupuk', 'foto' => 'obat-pupuk.png'],
            ['productName' => 'Peralatan', 'foto' => 'peralatan.png'],
            ['productName' => 'pakan ternak', 'foto' => 'buah.PNG']
            
        ];

        foreach ( $data as $value){
            ProductCategory::insert([
                'productName' => $value['productName'],
                'foto' => $value['foto'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        };


    }
}
