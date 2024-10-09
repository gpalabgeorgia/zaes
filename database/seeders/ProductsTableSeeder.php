<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id'=>1, 'category_id'=>2, 'section_id'=>1, 'product_name'=>'Blue Casual T-Shirt', 'product_code'=>'BT001', 'product_color'=>'blue', 'product_price'=>'150', 'product_discount'=>10, 'product_weight'=>200, 'product_video'=>'', 'main_image'=>'', 'description'=>'Test product', 'wash_care'=>'', 'fabric'=>'', 'pattern'=>'', 'sleeve'=>'', 'fit'=>'', 'occasion'=>'', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'is_featured'=>'No', 'status'=>1],
            ['id'=>2, 'category_id'=>2, 'section_id'=>1, 'product_name'=>'Red Casual T-Shirt', 'product_code'=>'RT001', 'product_color'=>'red', 'product_price'=>'250', 'product_discount'=>10, 'product_weight'=>200, 'product_video'=>'', 'main_image'=>'', 'description'=>'Test product', 'wash_care'=>'', 'fabric'=>'', 'pattern'=>'', 'sleeve'=>'', 'fit'=>'', 'occasion'=>'', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'is_featured'=>'Yes', 'status'=>1],
        ];
        Product::insert($productRecords);
    }
}
