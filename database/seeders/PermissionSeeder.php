<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $permissions = [
            'Add',
            'Edit',
            'Details',
            'Delete',
            'employee',
            'company',
            'roles',
            'permissions'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }
    }
}
