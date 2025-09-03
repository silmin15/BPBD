<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan roles ada
        foreach (['Super Admin', 'PK', 'KL', 'RR', 'Staf BPBD'] as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        // Super Admin (email kamu) — password di-hash & sudah terverifikasi
        $superAdmin = User::updateOrCreate(
            ['email' => 'izzamubarak878@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin'), // <— WAJIB hash
                'email_verified_at' => now(),           // <— tandai verified
            ]
        );
        $superAdmin->syncRoles(['Super Admin']);

        // Contoh staf
        $staf = User::updateOrCreate(
            ['email' => 'staf@bpbd.go.id'],
            [
                'name' => 'Staf BPBD 01',
                'password' => Hash::make('Staf'),       // <— hash juga
                'email_verified_at' => now(),
            ]
        );
        $staf->syncRoles(['Staf BPBD']); // atau salah satu dari PK/KL/RR sesuai kebutuhan
    }
}
