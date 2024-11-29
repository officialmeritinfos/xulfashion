<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SET UP DEFAULT CONSTANTS THAT WILL BE USED IN THE APPLICATION
    |--------------------------------------------------------------------------
    */

    'vPay'=>[
        'pubKey'    =>'dd571119-2f6d-469b-908f-3488ffdf5254',
        'secKey'    =>'*****',
        'live'      =>true
    ],
    'flutterwave'=>[
        'testPubKey'    =>env('FLUTTERWAVE_TEST_PUBLIC_KEY'),
        'testSecKey'    =>env('FLUTTERWAVE_TEST_SECRET_KEY'),
        'url'           =>'https://api.flutterwave.com/v3/',
        'secHash'       =>'*****',
        'pubKey'        =>env('FLUTTERWAVE_PUBLIC_KEY'),
        'secKey'        =>env('FLUTTERWAVE_SECRET_KEY'),
        'encKey'        =>'******',
        'live'          =>false
    ],
    'paystack'=>[
        'testSecKey'    =>env('PAYSTACK_TEST_SECRET_KEY'),
        'testPubKey'    =>env('PAYSTACK_TEST_PUBLIC_KEY'),
        'liveSecKey'    =>env('PAYSTACK_SECRET_KEY'),
        'livePubKey'    =>env('PAYSTACK_PUBLIC_KEY'),
        'live'          =>false,
        'url'           =>'https://api.paystack.co/'
    ],
    'nomba'=>[
        'testSecKey'    =>env('NOMBA_TEST_SECRET_KEY'),
        'testPubKey'    =>env('NOMBA_TEST_CLIENT_KEY'),
        'liveSecKey'    =>env('NOMBA_SECRET_KEY'),
        'livePubKey'    =>env('NOMBA_CLIENT_KEY'),
        'clientId'      =>env('NOMBA_CLIENT_ID'),
        'live'          =>false,
        'url'           =>config('constant.nomba.live')?'https://api.nomba.com/v1/':'https://sandbox.nomba.com/v1/'
    ]
];
