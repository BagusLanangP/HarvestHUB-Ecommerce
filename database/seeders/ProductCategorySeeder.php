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
            ['productName' => 'Sayur'],
            ['productName' => 'Buah'],
            ['productName' => 'Hewani'],
            ['productName' => 'Obat'],
            ['productName' => 'Peralatan'],
            ['productName' => 'Nabati']
            
        ];

        foreach ( $data as $value){
            ProductCategory::insert([
                'productName' => $value['productName'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        };


    }
}
