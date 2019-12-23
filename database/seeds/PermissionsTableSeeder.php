<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
         * Add Permissions
         *
         */
        /* permission for User module start */
        if (Permission::where('name', '=', 'Can View Users')->first() === null) {
            Permission::create(['name' => 'Can View Users', 'slug' => 'view.users', 'description' => 'Can view users', 'model' => 'User',]);
        }

        if (Permission::where('name', '=', 'Can Create Users')->first() === null) {
            Permission::create(['name' => 'Can Create Users', 'slug' => 'create.users', 'description' => 'Can create new users', 'model' => 'User',]);
        }

        if (Permission::where('name', '=', 'Can Edit Users')->first() === null) {
            Permission::create(['name' => 'Can Edit Users', 'slug' => 'edit.users', 'description' => 'Can edit users', 'model' => 'User',]);
        }

        if (Permission::where('name', '=', 'Can Active/DeActiate Users')->first() === null) {
            Permission::create(['name' => 'Can Active/DeActiate Users', 'slug' => 'activeinactive.users', 'description' => 'Can activate/deactivate users', 'model' => 'User',]);
        }
        /* permission for User module end */

        /* permission for Role module start */
        if (Permission::where('name', '=', 'View Roles')->first() === null) {
            Permission::create(['name' => 'View Roles', 'slug' => 'view.roles', 'description' => 'Can view roles','model' => 'Role',]);
        }

        if (Permission::where('name', '=', 'Create Roles')->first() === null) {
            Permission::create(['name' => 'Create Roles' ,'slug' => 'create.roles', 'description' => 'Can create new roles', 'model' => 'Role',]);
        }

        if (Permission::where('name', '=', 'Edit Roles')->first() === null) {
            Permission::create(['name' => 'Edit Roles', 'slug' => 'edit.roles', 'description' => 'Can edit roles', 'model' => 'Role',]);
        }

        /* permission for user module end */

        /* permission for States module start */
        if (Permission::where('name', '=', 'Can View States')->first() === null) {
            Permission::create(['name' => 'Can View States', 'slug' => 'view.states', 'description' => 'Can view States', 'model' => 'States',]);
        }

        if (Permission::where('name', '=', 'Can Create States')->first() === null) {
            Permission::create(['name' => 'Can Create States', 'slug' => 'create.states', 'description' => 'Can create new States', 'model' => 'States',]);
        }

        if (Permission::where('name', '=', 'Can Edit States')->first() === null) {
            Permission::create(['name' => 'Can Edit States', 'slug' => 'edit.states', 'description' => 'Can edit States', 'model' => 'States',]);
        }

        if (Permission::where('name', '=', 'Can Active/DeActiate States')->first() === null) {
            Permission::create(['name' => 'Can Active/DeActiate States', 'slug' => 'activeinactive.states', 'description' => 'Can activate/deactivate States', 'model' => 'States',]);
        }
        /* permission for States module end */

        /* permission for City module start */
        if (Permission::where('name', '=', 'Can View City')->first() === null) {
            Permission::create(['name' => 'Can View City', 'slug' => 'view.cities', 'description' => 'Can view city', 'model' => 'City',]);
        }

        if (Permission::where('name', '=', 'Can Create City')->first() === null) {
            Permission::create(['name' => 'Can Create City', 'slug' => 'create.cities', 'description' => 'Can create new city', 'model' => 'City',]);
        }

        if (Permission::where('name', '=', 'Can Edit City')->first() === null) {
            Permission::create(['name' => 'Can Edit City', 'slug' => 'edit.cities', 'description' => 'Can edit city', 'model' => 'City',]);
        }
        if (Permission::where('name', '=', 'Can Active/DeActiate City')->first() === null) {
            Permission::create(['name' => 'Can Active/DeActiate City', 'slug' => 'activeinactive.cities', 'description' => 'Can activate/deactivate City', 'model' => 'City',]);
        }

        /* permission for City module end */

        /* permission for Party module start */
        if (Permission::where('name', '=', 'Can View Party')->first() === null) {
            Permission::create(['name' => 'Can View Party', 'slug' => 'view.parties', 'description' => 'Can view Party', 'model' => 'Party',]);
        }
        if (Permission::where('name', '=', 'Can Create Party')->first() === null) {
            Permission::create(['name' => 'Can Create Party', 'slug' => 'create.parties', 'description' => 'Can create new Party', 'model' => 'Party',]);
        }
        if (Permission::where('name', '=', 'Can Edit Party')->first() === null) {
            Permission::create(['name' => 'Can Edit Party', 'slug' => 'edit.parties', 'description' => 'Can edit Party', 'model' => 'Party',]);
        }
        if (Permission::where('name', '=', 'Can Active/DeActiate Party')->first() === null) {
            Permission::create(['name' => 'Can Active/DeActiate Party', 'slug' => 'activeinactive.parties', 'description' => 'Can activate/deactivate Party', 'model' => 'Party',]);
        }
        /* permission for Party module end */

        /* permission for Category module start */
        if (Permission::where('name', '=', 'Can View Category')->first() === null) {
            Permission::create(['name' => 'Can View Category', 'slug' => 'view.categories', 'description' => 'Can view categories', 'model' => 'Category',]);
        }

        if (Permission::where('name', '=', 'Can Create Category')->first() === null) {
            Permission::create(['name' => 'Can Create Category', 'slug' => 'create.categories', 'description' => 'Can create new categories', 'model' => 'Category',]);
        }

        if (Permission::where('name', '=', 'Can Edit Category')->first() === null) {
            Permission::create(['name' => 'Can Edit Category', 'slug' => 'edit.categories', 'description' => 'Can edit categories', 'model' => 'Category',]);
        }

        if (Permission::where('name', '=', 'Can Active/DeActiate Category')->first() === null) {
            Permission::create(['name' => 'Can Active/DeActiate Category', 'slug' => 'activeinactive.categories', 'description' => 'Can activate/deactivate categories', 'model' => 'Category',]);
        }
        /* permission for Category module end */

        /* permission for Product module start */
        if (Permission::where('name', '=', 'Can View Product')->first() === null) {
            Permission::create(['name' => 'Can View Product', 'slug' => 'view.products', 'description' => 'Can view products', 'model' => 'Product',]);
        }

        if (Permission::where('name', '=', 'Can Create Product')->first() === null) {
            Permission::create(['name' => 'Can Create Product', 'slug' => 'create.products', 'description' => 'Can create new products', 'model' => 'Product',]);
        }

        if (Permission::where('name', '=', 'Can Edit Product')->first() === null) {
            Permission::create(['name' => 'Can Edit Product', 'slug' => 'edit.products', 'description' => 'Can edit products', 'model' => 'Product',]);
        }

        if (Permission::where('name', '=', 'Can Active/DeActiate Product')->first() === null) {
            Permission::create(['name' => 'Can Active/DeActiate Product', 'slug' => 'activeinactive.products', 'description' => 'Can activate/deactivate products', 'model' => 'Product',]);
        }
        /* permission for Product module end */

        /* permission for Party_Master module start */
        if (Permission::where('name', '=', 'Can View Party Master')->first() === null) {
            Permission::create(['name' => 'Can View Party Master', 'slug' => 'view.party_master', 'description' => 'Can view party master', 'model' => 'PartyMaster',]);
        }

        if (Permission::where('name', '=', 'Can Create Party Master')->first() === null) {
            Permission::create(['name' => 'Can Create Party Master', 'slug' => 'create.party_master', 'description' => 'Can create new party master', 'model' => 'PartyMaster',]);
        }

        if (Permission::where('name', '=', 'Can Edit Party Master')->first() === null) {
            Permission::create(['name' => 'Can Edit Party Master', 'slug' => 'edit.party_master', 'description' => 'Can edit party master', 'model' => 'PartyMaster',]);
        }

        if (Permission::where('name', '=', 'Can Active/DeActiate Party Master')->first() === null) {
            Permission::create(['name' => 'Can Active/DeActiate Party Master', 'slug' => 'activeinactive.party_master', 'description' => 'Can activate/deactivate party master', 'model' => 'PartyMaster',]);
        }
        /* permission for Party_Master module end */

        /* permission for Order module start */
        if (Permission::where('name', '=', 'Can View Order')->first() === null) {
            Permission::create(['name' => 'Can View Order', 'slug' => 'view.orders', 'description' => 'Can view order', 'model' => 'Order',]);
        }

        if (Permission::where('name', '=', 'Can Create Order')->first() === null) {
            Permission::create(['name' => 'Can Create Order', 'slug' => 'create.orders', 'description' => 'Can create new orders', 'model' => 'Order',]);
        }

        if (Permission::where('name', '=', 'Can Edit Order')->first() === null) {
            Permission::create(['name' => 'Can Edit Order', 'slug' => 'edit.orders', 'description' => 'Can edit orders', 'model' => 'Order',]);
        }

        if (Permission::where('name', '=', 'Can Delete Order')->first() === null) {
            Permission::create(['name' => 'Can Delete Order', 'slug' => 'delete.orders', 'description' => 'Can delete orders', 'model' => 'Order',]);
        }

        /* permission for City module end */

        /* permission for Setting module start */
        if (Permission::where('name', '=', 'View Settings')->first() === null) {
            Permission::create(['name' => 'View Settings', 'slug' => 'view.settings', 'description' => 'Can view OMS Settings','model' => 'Setting',]);
        }

        if (Permission::where('name', '=', 'Edit Settings')->first() === null) {
            Permission::create(['name' => 'Edit Settings', 'slug' => 'edit.settings', 'description' => 'Can edit Settings', 'model' => 'Setting',]);
        }
        /* permission for Settings module end */

    }
}
