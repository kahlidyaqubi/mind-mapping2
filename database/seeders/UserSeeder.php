<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        $user = new User();
        $user->name = 'user1';
        $user->email = 'c1@c.c';
        $user->email_verified_at = Carbon::now();
        $user->password = bcrypt(123456);
        $user->phone = '597234815';
		$user->age = 15;
		$user->memorization_level = 'keeper';
        $user->country_id = 1;
        $user->save();

        
    }
}
