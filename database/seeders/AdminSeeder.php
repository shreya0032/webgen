<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
        use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        $user = Employee::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            // 'avatar' => 'default_avatar.jpg',
            'phone' => '7891472583',
            'password' => Hash::make('password'), 
            
        ])->assignRole('super admin');
    }
}
