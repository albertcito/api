<?php
$CUSTOMER_URL = env('CUSTOMER_URL', 'http://localhost:7231');
return [
    'URL' => [
        'active-email' => $CUSTOMER_URL . '/active-email?token=%s',
        'reset-pass' => $CUSTOMER_URL . '/reset-pass?token=%s',
        'zip' => $CUSTOMER_URL . '/zip',
    ],

];
