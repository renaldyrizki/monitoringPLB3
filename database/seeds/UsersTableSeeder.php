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
            'password' => bcrypt('rahasia'),
            'created_at'	=> date('Y-m-d h:i:s'),
            'updated_at'	=> date('Y-m-d h:i:s'),
        ]);
    }
}
