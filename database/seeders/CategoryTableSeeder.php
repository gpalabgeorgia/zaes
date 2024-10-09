<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            ['id'=>1, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'სპორტული', 'category_image'=>'', 'category_discount'=>0, 'description' => '', 'url'=>'sport', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>2, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'კლასიკური', 'category_image'=>'', 'category_discount'=>0, 'description' => '', 'url'=>'sport', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>3, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'ზაფხულის', 'category_image'=>'', 'category_discount'=>0, 'description' => '', 'url'=>'sport', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>4, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'ზამთარი', 'category_image'=>'', 'category_discount'=>0, 'description' => '', 'url'=>'sport', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>5, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'შემოდგომა', 'category_image'=>'', 'category_discount'=>0, 'description' => '', 'url'=>'sport', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
        ];
        Category::insert($categoryRecords);
    }
}
