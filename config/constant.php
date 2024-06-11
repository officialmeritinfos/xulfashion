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
        'testPubKey'    =>'FLWPUBK_TEST-947de2621588b85de1ad6eb68ef4a1b3-X',
        'testSecKey'    =>'FLWSECK_TEST-69264747535477addbd3996cfa57c3c7-X',
        'testEncKey'    =>'FLWSECK_TEST17aea0267b88',
        'url'           =>'https://api.flutterwave.com/v3/',
        'secHash'       =>'*****',
        'pubKey'        =>'*****',
        'secKey'        =>'*****',
        'encKey'        =>'******',
        'live'          =>false
    ],
    'paystack'=>[
        'testSecKey'    =>'sk_test_75f6ba26c72eebd5e3ba53fbec828a85969b6f52',
        'testPubKey'    =>'pk_test_2f3096160be1e626bd011224914b5ada0c7107ff',
        'liveSecKey'    =>'*****',
        'livePubKey'    =>'*****',
        'live'          =>false,
        'url'           =>'https://api.paystack.co/'
    ]
];
