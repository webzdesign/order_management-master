<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        if (User::where('email', '=', 'admin@admin.com')->first() === null) {
            $adminRole = Role::where('slug', '=', 'superadmin')->first();
            $newUser = User::create([
                'name'              => 'Super Admin',
                'email'             => 'superadmin@admin.com',
                'password'          => bcrypt('123456'),
                'status'            => 1                
            ]);
            $newUser->attachRole($adminRole);
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                $adminRole->attachPermission($permission);
            }
        
        }
    }
}
