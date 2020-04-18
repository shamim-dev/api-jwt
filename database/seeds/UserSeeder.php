<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'userType' => '1',
            'status' => '1',
            'userName' => 'shamim',
            'email' => 'shamim@gmail.com',
            'phone' => '01814111176',
            'password' => Hash::make('123456'),
        ]);
    }
}
