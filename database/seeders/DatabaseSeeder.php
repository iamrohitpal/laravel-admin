<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $permissions = [
            'Dashboard',
            'Category',
            'Sub Category',
            'Product',
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
