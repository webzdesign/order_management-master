<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add Roles
         *
         */

        if (Role::where('name', '=', 'Super Admin')->first() === null) {
            Role::create([
               'name'        => 'Super Admin',
               'slug'        => 'superadmin',
               'description' => 'Super Admin Role',
               'level'       => 5,
           ]);
       }

        if (Role::where('name', '=', 'Admin')->first() === null) {
             Role::create([
                'name'        => 'Admin',
                'slug'        => 'Admin',
                'description' => 'Admin Role',
                'level'       => 1,
            ]);
        }

        if (Role::where('name', '=', 'User')->first() === null) {
            Role::create([
                'name'        => 'User',
                'slug'        => 'user',
                'description' => 'User Role',
                'level'       => 1,
            ]);
        }
        
    }
}
