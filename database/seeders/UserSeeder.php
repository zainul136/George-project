<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Admin',
            'email' => 'info@weboscy.com',
            'password' =>  Hash::make('Ct$OKK@mt#UsxCbSsSZ5m0&dy'),
            'type' =>  'admin',
        ]);
    }
}
