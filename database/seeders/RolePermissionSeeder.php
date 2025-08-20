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
        permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'view inventaris']);
        Permission::create(['name' => 'pinjam inventaris']);
        Permission::create(['name' => 'kembalikan inventaris']);




        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Sekertariat']);
        Role::create(['name' => 'PK']);
        Role::create(['name' => 'KL']);
        Role::create(['name' => 'RR']);
        Role::create(['name' => 'Petugas Aset K']);
        Role::create(['name' => 'Petugas Aset B']);
        Role::create(['name' => 'Staf BPBD'])->givePermissionTo('view dashboard', 'view inventaris', 'pinjam inventaris', 'kembalikan inventaris');



        $superAdminRole = Role::findByName('Super Admin');
        $superAdminRole->givePermissionTo(Permission::all());
    }
}
