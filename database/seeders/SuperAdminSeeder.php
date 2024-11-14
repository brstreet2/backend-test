<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name'      => 'Super Admin',
            'email'     => 'super@admin.com',
            'role'      => 'super_admin',
            'password'  => Hash::make('Password123!')
        ];

        User::create($data);
    }
}
