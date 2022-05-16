<?php

use Illuminate\Database\Seeder;
use DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id'=> 1 , 'role_name' => 'super_admin'],
            ['id'=> 2 , 'role_name' => 'admin'],
            ['id'=> 3 , 'role_name' => 'guest'],
            ['id'=> 4 , 'role_name' => 'afler'],
            ['id'=> 5 , 'role_name' => 'aflee'],
        ]);
    }
}
