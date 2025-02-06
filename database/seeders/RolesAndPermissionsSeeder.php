<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Membuat permissions
        $managePhotos = Permission::create(['name' => 'manage photos']);
        $manageCategories = Permission::create(['name' => 'manage categories']);
        $manageDashboard = Permission::create(['name' => 'manage dashboard']);
        $manageUsers = Permission::create(['name' => 'manage users']);
        $viewStatistics = Permission::create(['name' => 'view statistics']);
        $viewPhotos = Permission::create(['name' => 'view photos']);

        // Membuat roles
        $admin = Role::create(['name' => 'admin']);
        $pegawai = Role::create(['name' => 'pegawai']);
        $viewer = Role::create(['name' => 'viewer']);

        // Memberikan permissions ke roles
        $admin->givePermissionTo([
            $managePhotos,
            $manageCategories,
            $manageDashboard,
            $manageUsers,
            $viewStatistics
        ]);

        $pegawai->givePermissionTo([
            $managePhotos,
            $manageDashboard,
            $viewStatistics
        ]);

        $viewer->givePermissionTo($viewPhotos);
    }
}
