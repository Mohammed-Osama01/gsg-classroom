<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Query Builder
        DB::table('users')->insert([
            'name' => 'Mohmad Osama',
            'email' =>'m@gmail.com',
            'password'=>Hash::make('password'), // sha , md5 , Rsa
        ]);
    }
}
