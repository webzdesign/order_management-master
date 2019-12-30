<?php

return [
    'user'       => 'User',
    'detail'     => ':module Details',
    'add'        => 'Add :module',
    'edit'       => 'Edit :module',
    'name'       => 'Name',
    'email'      => 'Email',
    'password'   => 'Password',
    'confirm_password'   => 'Confirm Password',    
    'select_role'   => 'Select Role',
    'status'     => 'Status',
	'active'     => 'Active',
    'deactive'   => 'deactive',
    'permissions' => 'Permissions',

	/** Button */
	'btn' =>
	[
		'New'       => 'New',
		'Edit'      => 'Edit',
		'Active'    => 'Activate',
		'Deactive'  => 'Deactivate',
		'Back'      => 'Back',
		'Cancel'    => 'Cancel',
		'Submit'    => 'Submit',
		'Add'       => 'Add',
	],

	/** Placeholder */
	'placeholder' =>
	[
        'user_name'     => 'Enter User Name',
        'user_email'    => 'Enter User Email',
        'user_password' => 'Enter Password',
        'user_confirm'  => 'Enter Confirm Password',
        'user_email'    => 'Enter User Email',
	],

	/** Error Message */
	'message' =>
	[
        'user_name'     => 'Name Is Required.',
        'user_email'    => 'Email Is Required.',
        'user_role'    => 'Role Is Required.',
		'email_remote'  => 'Email Already exits.',
        'user_status'   => 'Status Is Required.',
        'user_password' => 'Enter Password.',
        'password_minlength' => 'Password Minimum 6 Characters.',
        'password_maxlength' => 'Password Maximum 10 Characters.',
        'confirm_password'  => 'Confirm Password Is Required.',
        'password_equalTo'  => 'Enter Confirm Password Same as Password',
	],

	'tfield' =>
	[
		'sr_no'     => 'SrNo',
        'name'      => 'Name',
        'email'     => 'Email',
        'user_role' => 'User Role',
		'status'    => 'Status',
		'action'    => 'Action'
    ],
    'alert' => 
    [
        'insert'    => 'User Insert Successfully !',
        'update'    => 'User Update Successfully !',
        'activate'  => 'User Activated Successfully !',
        'deactivate'  => 'User Deactivated Successfully !',
        'confirm_activate'  => 'Are you sure want to Activate?',
        'confirm_deactivate'  => 'Are you sure want to Deactivate?',
        'confirm_text'  => 'As that can be undone by doing reverse.',
        'confirm_alert'  => 'Yes',
        'cancel_alert'  => 'Cancel',
    ],
];