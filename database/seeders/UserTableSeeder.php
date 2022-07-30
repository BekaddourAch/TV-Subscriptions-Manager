<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'Super Admin',
            'username' => 'super_admin',
            'email' => 'super_admin@app.com',
            'mobile' => '966500000000',
            'password' => bcrypt('123123123'),
        ]);

        $user->attachRole('superadmin');
    }
}
