<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'            => 'Super Admin',
                'username'        => 'superadmin',
                'password'        => 'admin123',
                'role'            => User::ROLE_ADMIN,
                'is_active'       => true,
                'status_kerja'    => User::STATUS_AKTIF,
                'shift_jaga'      => User::SHIFT_PAGI,
                'tanggal_bergabung' => now(),
            ]
        );
    }
}

