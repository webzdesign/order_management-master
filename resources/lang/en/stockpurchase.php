<?php

return [
    'purchase'   => 'Purchase',
    'detail'     => ':module Details',
    'add'        => 'Add :module',
    'edit'       => 'Edit :module',
    'select'     =>  'Select',
    'date'       => 'Date',
    'purchase_detail' => 'Purchase Details',

	/** Button */
	'btn' =>
	[
		'New'       => 'New',
        'Edit'      => 'Edit',
        'Delete'    => 'Delete',
		'Back'      => 'Back',
		'Cancel'    => 'Cancel',
		'Submit'    => 'Submit',
        'Add'       => 'Add',
	],

	/** Placeholder */
	'placeholder' =>
	[
        'select_date'  => 'Select Date',
        'qty'   => 'Qty',
	],

	/** Error Message */
	'message' =>
	[
        'product_err'=> 'Product Is Required.',
        'qty_err'    => 'Qty Is Required.',
	],

    /** Table Column */
	'tfield' =>
	[
		'sr_no'     => 'SrNo',
        'purchase_id'=> 'Purchase ID',
        'date'      => 'Date',
        'product'   => 'Product',
        'qty'       => 'Qty',
        'added_by'  => 'Added By',
		'action'    => 'Action'
    ],

    /**Alert Messages */
    'alert' => 
    [
        'insert'    => 'Purchase Insert Successfully !',
        'update'    => 'Purchase Update Successfully !',
        'delete'    => 'Purchase Deleted Successfully !',
        'confirm_delete'  => 'Are you sure want to Delete?',
        'confirm_text'  => 'As that can not be reverse.',
        'confirm_alert'  => 'Yes',
        'cancel_alert'  => 'Cancel',
    ],
];