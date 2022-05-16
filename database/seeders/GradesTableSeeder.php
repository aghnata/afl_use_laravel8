<?php

use Illuminate\Database\Seeder;
use DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->insert([
            ['id'=> 1 , 'level' => '1', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 2 , 'level' => '2', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 3 , 'level' => '3', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 4 , 'level' => '4', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 5 , 'level' => '5', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 6 , 'level' => '6', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 7 , 'level' => '7', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 8 , 'level' => '8', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 9 , 'level' => '9', 'primary_fee' => 50000, 'primary_cost' => 65000],
            ['id'=> 10 , 'level' => '10', 'primary_fee' => 60000, 'primary_cost' => 75000],
            ['id'=> 11 , 'level' => '11', 'primary_fee' => 60000, 'primary_cost' => 75000],
            ['id'=> 12 , 'level' => '12', 'primary_fee' => 60000, 'primary_cost' => 75000],
            ['id'=> 13 , 'level' => 'SMA to PTN', 'primary_fee' => 75000, 'primary_cost' => 90000],
            ['id'=> 14 , 'level' => 'TPB or Kuliah', 'primary_fee' => 75000, 'primary_cost' => 90000],
            ['id'=> 15 , 'level' => 'Olimp SMA', 'primary_fee' => 90000, 'primary_cost' => 110000],
            ['id'=> 16 , 'level' => 'Olimp SMP', 'primary_fee' => 75000, 'primary_cost' => 90000]
        ]);
    }
}
