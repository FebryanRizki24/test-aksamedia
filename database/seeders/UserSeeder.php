<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'nama admin',
            'username' => 'admin',
            'password' => Hash::make('pastibisa'),
            'phone' => '082131441234',
            'email' => 'admin@gmail.com'
        ]);
    }
}
