<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pagination default variables
    |--------------------------------------------------------------------------
    */
    'paginate' => [
        'page' => 0,
        'limit' => 20,
        'pageMin' => 0,
		'limitMin' => 1,
        'max' => 200,
    ],
    /*
    |--------------------------------------------------------
    | Stripe version to use unity test
    |--------------------------------------------------------
    */
    'stripeVersion' => '2018-05-21',
    'supportEmail' => 'support@devicepixel.com',
    'dateFormat' => [
        'full' => 'M d, Y h:mm A'
    ],
];
