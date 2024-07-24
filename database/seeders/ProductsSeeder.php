<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $createMultipleProducts = [
            ['name'=>'Snickers','price'=>20, 'quantity'=>20, 'status'=>'available', 'created_at'=>'2023-12-10 20:57:40', 'updated_at'=>'2023-12-10 20:57:40',
             'image'=>'files/uploaded/Snickers.jpeg',],
            ['name'=>'CornFlakes','price'=>25, 'quantity'=>0, 'status'=>'out_of_stock', 'created_at'=>'2023-12-13 20:45:10', 'updated_at'=>'2023-12-10 20:57:40',
            'image'=>'files/uploaded/CornFlakes.jpeg',],
            ['name'=>'Cocacola','price'=>35, 'quantity'=>121, 'status'=>'available', 'created_at'=>'2023-12-14 19:37:20', 'updated_at'=>'2023-12-10 20:57:40',
            'image'=>'files/uploaded/Cocacola.jpeg'],
            ['name'=>'Custard','price'=>105, 'quantity'=>136, 'status'=>'available', 'created_at'=>'2023-12-13 20:45:10', 'updated_at'=>'2023-12-10 20:57:40',
            'image'=>'files/uploaded/Custard.jpeg'],
        ];
        
        DB::table('products')->insert($createMultipleProducts);
    }
}
