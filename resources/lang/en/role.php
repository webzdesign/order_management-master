<?php

return [
    'role'      => 'Role',
    'detail'     => ':module Details',
    'add'        => 'Add :module',
    'edit'       => 'Edit :module',
    'role_name'  => 'Role Name',
    'role_description'  => 'Role Description',
    'permissions' => 'Permissions',

	/** Button */
	'btn' =>
	[
		'New'       => 'New',
		'Edit'      => 'Edit',
		'Back'      => 'Back',
		'Cancel'    => 'Cancel',
		'Submit'    => 'Submit',
        'Add'       => 'Add',
        'Admin'    => 'Admin',
        'Super_Admin' => 'Super Admin',
	],

	/** Placeholder */
	'placeholder' =>
	[
        'role_name' => 'Enter Role Name',
        'role_description' => 'Enter Description',
	],

	/** Error Message */
	'message' =>
	[
		'role_name'    => 'Role Name Is Required.',
		'role_remote'  => 'Role Name Already Exits.',
		'insert'       => 'Role Insert Successfully.',
        'update'       => 'Role Update Successfully.',
	],

	/** Table Column */
	'tfield' =>
	[
		'sr_no'    => 'SrNo',
		'name'     => 'Name',
		'description'  => 'Description',
		'action'   => 'Action'
	],
	
    /**Alert Messages */
    'alert' => 
    [
        'insert' => 'Role Insert Successfully !',
        'update' => 'Role Update Successfully !',
    ],
];
