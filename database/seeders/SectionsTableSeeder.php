<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sections;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionsRecords = [
            ['id'=>1, 'name'=>'მთავარი', 'status'=>1],
            ['id'=>2, 'name'=>'მამაკაცი', 'status'=>1],
            ['id'=>3, 'name'=>'ქალი', 'status'=>1],
            ['id'=>4, 'name'=>'ბავშვი', 'status'=>1],
        ];
        Sections::insert($sectionsRecords);
    }
}
