<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Gen Gen Gumilar",
            'email' => 'gengen@gmail.com',
            'npk' => '15152402',
            'password' => bcrypt('rahasia'),
            'isAdmin'	=> false,
            'plant_id'	=> 1,
            'created_at'	=> date('Y-m-d h:i:s'),
            'updated_at'	=> date('Y-m-d h:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => "Gen Gen Admin",
            'email' => 'admin@gmail.com',
            'npk' => '15152802',
            'password' => bcrypt('rahasia'),
            'isAdmin'	=> true,
            'plant_id'	=> 1,
            'created_at'	=> date('Y-m-d h:i:s'),
            'updated_at'	=> date('Y-m-d h:i:s'),
        ]);
    }
}
