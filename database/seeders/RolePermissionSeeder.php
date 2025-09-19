<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // ini masih contoh permission let
        Permission::firstOrCreate(['name' => 'view dashboard']);
        Permission::firstOrCreate(['name' => 'view inventaris']);
        Permission::firstOrCreate(['name' => 'pinjam inventaris']);
        Permission::firstOrCreate(['name' => 'kembalikan inventaris']);
        Permission::firstOrCreate(['name' => 'kejadian-bencana.manage']);




        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Sekertariat']);
        Role::firstOrCreate(['name' => 'PK']);
        Role::firstOrCreate(['name' => 'KL']);
        Role::firstOrCreate(['name' => 'RR']);
        Role::firstOrCreate(['name' => 'Petugas Aset K']);
        Role::firstOrCreate(['name' => 'Petugas Aset B']);
        
        $stafRole = Role::firstOrCreate(['name' => 'Staf BPBD']);
        $stafRole->givePermissionTo('view dashboard', 'view inventaris', 'pinjam inventaris', 'kembalikan inventaris');



        $superAdminRole = Role::findByName('Super Admin');
        $superAdminRole->givePermissionTo(Permission::all());

        $role = Role::findByName('KL');
        $role->givePermissionTo('kejadian-bencana.manage');
    }
}
