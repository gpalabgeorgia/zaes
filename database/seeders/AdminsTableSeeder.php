<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id'=>1, 'name'=>'naes','type'=>'admin','mobile'=>'123456789','email'=>'naes@info.com','password'=>'$2y$10$YFbONifXufQCbCJBtsJm4.L0KoPpjVvqlz0RAKQ7AIjvmElZHYOL.','image'=>'','status'=>1
            ],
        ];
        DB::table('admins')->insert($adminRecords);
        // foreach($adminRecords as $key => $record) {
        //     \App\Models\Admin::create($record);
        // }
    }
}
