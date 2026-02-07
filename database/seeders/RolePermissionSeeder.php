<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Pegawai permissions
            'view pegawai',
            'create pegawai',
            'edit pegawai',
            'delete pegawai',
            
            // Jabatan permissions
            'view jabatan',
            'create jabatan',
            'edit jabatan',
            'delete jabatan',
            
            // Department permissions
            'view department',
            'create department',
            'edit department',
            'delete department',
            
            // User permissions
            'view user',
            'create user',
            'edit user',
            'delete user',
            
            // Attendance permissions
            'view attendance',
            'create attendance',
            'edit attendance',
            'view all attendance',
            
            // Leave permissions
            'view leave',
            'create leave',
            'approve leave',
            'view all leave',
            
            // Salary permissions
            'view salary',
            'create salary',
            'edit salary',
            'view all salary',
            
            // Report permissions
            'view reports',
            'export reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $hrRole = Role::create(['name' => 'hr']);
        $hrRole->givePermissionTo([
            'view pegawai', 'create pegawai', 'edit pegawai',
            'view jabatan', 'create jabatan', 'edit jabatan',
            'view department', 'create department', 'edit department',
            'view attendance', 'create attendance', 'edit attendance', 'view all attendance',
            'view leave', 'approve leave', 'view all leave',
            'view salary', 'create salary', 'edit salary', 'view all salary',
            'view reports', 'export reports',
        ]);

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view pegawai',
            'view jabatan',
            'view department',
            'view attendance', 'view all attendance',
            'view leave', 'approve leave', 'view all leave',
            'view reports',
        ]);

        $pegawaiRole = Role::create(['name' => 'pegawai']);
        $pegawaiRole->givePermissionTo([
            'view attendance', 'create attendance',
            'view leave', 'create leave',
            'view salary',
        ]);
    }
}
