<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's admin accounts.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Ishanka Costha',
                'email' => 'ishankacostha@gmail.com',
            ],
            [
                'name' => 'Shehan Megana',
                'email' => 'shehanmegana@gmail.com',
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make('password'),
                    'is_admin' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->warn('Admin accounts seeded with temporary password "password". Change this after first login.');
    }
}
