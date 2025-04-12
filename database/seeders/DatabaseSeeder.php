<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'description' => 'Admin',
            'permission_type' => 'all',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => Hash::make('123456'),
        ]);

        $permissions = [
            'Dashboard',
            'Category',
            'Sub Category',
            'Product',
            'Blog',
            'Seo',
            'Enquiry',
            'Role',
            'User',
        ];

        $types = [
            'Create',
            'Edit',
            'Delete',
        ];

        foreach ($permissions as $key => $permission) {
            Permission::create([
                'name' => $permission,
                'slug' => $permission,
                'groupby' => $key,
            ]);
            if ($key !== 0) {
                foreach ($types as $type) {
                    Permission::create([
                        'name' => $type,
                        'slug' => $type,
                        'groupby' => $key,
                    ]);
                }
            }
        }
    }
}
