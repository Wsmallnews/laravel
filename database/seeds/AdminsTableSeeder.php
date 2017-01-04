<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => '超级管理员',
            'email' => 'smallnews@example.com',
            'password' => bcrypt('123456')
        ]);
    }
}
