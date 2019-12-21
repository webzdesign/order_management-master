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
        if (Role::where('name', '=', 'Administrator')->first() === null) {
             Role::create([
                'name'        => 'Administrator',
                'slug'        => 'administrator',
                'description' => 'Admin Role',
                'level'       => 5,
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

        if (Role::where('name', '=', 'Unverified')->first() === null) {
            Role::create([
                'name'        => 'Unverified',
                'slug'        => 'unverified',
                'description' => 'Unverified Role',
                'level'       => 0,
            ]);
        }
    }
}
