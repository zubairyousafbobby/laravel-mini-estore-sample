<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Abdul Hadi',
            "email"=>"zubair.yousaf.bobby@gmail.com",
            "password"=>Hash::make('12345')
        ]);
    }
}
