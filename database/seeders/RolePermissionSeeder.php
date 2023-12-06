<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolePermission::create([
            'role' => 'dashboard',
            'description' => '',
            'permission' => '1',
            'type' => 'employees'
        ]);
        RolePermission::create([
            'role' => 'employees',
            'description' => '',
            'permission' => '1',
            'type' => 'employees'
        ]);
        RolePermission::create([
            'role' => 'companies',
            'description' => '',
            'permission' => '1',
            'type' => 'employees'
        ]);
        RolePermission::create([
            'role' => 'projects',
            'description' => 'Only View Access to the Assigned projects.',
            'permission' => '1',
            'type' => 'employees'
        ]);
        RolePermission::create([
            'role' => 'clients',
            'description' => '',
            'permission' => '1',
            'type' => 'employees'
        ]);
        RolePermission::create([
            'role' => 'contractors',
            'description' => '',
            'permission' => '1',
            'type' => 'employees'
        ]);
        RolePermission::create([
            'role' => 'invitation',
            'description' => '',
            'permission' => '1',
            'type' => 'employees'
        ]);
        RolePermission::create([
            'role' => 'dashboard',
            'description' => '',
            'permission' => '1',
            'type' => 'contractors'
        ]);
        RolePermission::create([
            'role' => 'employees',
            'description' => '',
            'permission' => '1',
            'type' => 'contractors'
        ]);
        RolePermission::create([
            'role' => 'companies',
            'description' => '',
            'permission' => '1',
            'type' => 'contractors'
        ]);
        RolePermission::create([
            'role' => 'projects',
            'description' => 'Only View Access to the Assigned projects project cost and other contractor prices will be hidden.',
            'permission' => '1',
            'type' => 'contractors'
        ]);
        RolePermission::create([
            'role' => 'clients',
            'description' => '',
            'permission' => '1',
            'type' => 'contractors'
        ]);
        RolePermission::create([
            'role' => 'contractors',
            'description' => '',
            'permission' => '1',
            'type' => 'contractors'
        ]);
        RolePermission::create([
            'role' => 'invitation',
            'description' => '',
            'permission' => '1',
            'type' => 'contractors'
        ]);
    }
}
