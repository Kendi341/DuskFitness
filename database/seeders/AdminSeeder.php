<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create the first user who is the super admin
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'Kendi', 
            'address'=>'LANGATA',
            'phone'=>'722100100',
            'email' => 'kendi@gmail.com', 
            'password' => bcrypt('Kendi@123'), 
            'role' => -1
        ]);

    }
}
