<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@bpbd.go.id',
            'password' => 'superadmin'
        ]);
        $superAdmin->assignRole('Super Admin');

        $staf = User::create([
            'name' => 'Staf BPBD 01',
            'email' => 'staf@bpbd.go.id',
            'password' => bcrypt('Staf')
        ]);
        $staf->assignRole('Staf BPBD');
    }
}
