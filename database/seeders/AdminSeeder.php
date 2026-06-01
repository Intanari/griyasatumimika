<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'paulinaari93@gmail.com'],
            [
                'name'         => 'Paulina Ari',
                'username'     => 'paulinaari93',
                'password'     => 'paulinaari93',
                'role'         => User::ROLE_SUPER_ADMIN,
                'is_active'    => true,
                'status_kerja' => User::STATUS_AKTIF,
            ]
        );

        $this->command->info('Super Admin seeded: paulinaari93@gmail.com');
    }
}
