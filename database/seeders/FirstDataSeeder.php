<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirstDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \App\Models\User::insert([
            ['name' => 'test@test.com ', 'is_active' => 0, 'country_id' => 1, 'email' => 'test@test.com', 'password' => Hash::make('test@test.com')],
        ]);
    }
}