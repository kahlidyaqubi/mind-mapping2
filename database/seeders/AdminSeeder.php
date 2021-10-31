<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Super Admin
        $superAdmin = new Admin();
        $superAdmin->name = 'Administrator';
        $superAdmin->email = 'admin@admin.com';
        $superAdmin->password = bcrypt(123456);
        $superAdmin->phone = '+12345678';
        $superAdmin->save();


    }
}
