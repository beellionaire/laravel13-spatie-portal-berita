<?php

namespace Database\Seeders;

use App\Models\User;
use App\PermissionEnum;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach(PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate(['name' => $permission->value]);
        }

        $penulisRole = Role::firstOrCreate(['name' => 'penulis']);
        $penulisRole->syncPermissions([
            PermissionEnum::VIEW_POSTS->value,
            PermissionEnum::CREATE_POSTS->value,
            PermissionEnum::EDIT_POSTS->value,
            PermissionEnum::DELETE_POSTS->value
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            // Wewenang User
            PermissionEnum::VIEW_USERS->value,
            PermissionEnum::CREATE_USERS->value,
            PermissionEnum::EDIT_USERS->value,
            PermissionEnum::DELETE_USERS->value,
            
            // TAMBAHKAN Wewenang Artikel
            PermissionEnum::VIEW_POSTS->value,
            PermissionEnum::CREATE_POSTS->value,
            PermissionEnum::EDIT_POSTS->value,
            PermissionEnum::DELETE_POSTS->value,
        ]);

        $admin = User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'admin', 'password' => Hash::make('admin123')
        ]);

        $admin->assignRole('admin');

        $penulis = User::firstOrCreate(['email' => 'penulis@gmail.com'], 
        [
            'name' => 'penulis 1',
            'password' => Hash::make('penulis123')
        ]);

        $penulis->assignRole('penulis');

    }
}
