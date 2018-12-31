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
        $objFaker = \Faker\Factory::create();

        DB::table('users')->insert([
            'username' => $objFaker->name,
            'email' => 'federeale@globant.com',
            'password' => \Hash::make('secret'),
            'active' => 1,
            'account_verified' => 1
        ]);
    }
}
