<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SET UP DEFAULT CONSTANTS THAT WILL BE USED IN THE APPLICATION
    |--------------------------------------------------------------------------
    */

    'vPay'=>[
        'pubKey'    =>'dd571119-2f6d-469b-908f-3488ffdf5254',
        'secKey'    =>'ac9d962d-80eb-4cc0-8d8a-2d4317f26a87',
        'live'      =>true
    ],
    'flutterwave'=>[
        'testPubKey'    =>'FLWPUBK_TEST-947de2621588b85de1ad6eb68ef4a1b3-X',
        'testSecKey'    =>'FLWSECK_TEST-69264747535477addbd3996cfa57c3c7-X',
        'testEncKey'    =>'FLWSECK_TEST17aea0267b88',
        'url'           =>'https://api.flutterwave.com/v3/',
        'secHash'       =>'meritinfos47298815Me!',
        'pubKey'        =>'FLWPUBK-3c4fc875c58e3972e22065dbed652b6a-X',
        'secKey'        =>'FLWSECK-c628ce172ec27f81cffd9c6ff142ba87-18bf3b79896vt-X',
        'encKey'        =>'c628ce172ec24f2ea360b9eb',
        'live'          =>false
    ],
    'paystack'=>[
        'testSecKey'    =>'sk_test_75f6ba26c72eebd5e3ba53fbec828a85969b6f52',
        'testPubKey'    =>'pk_test_2f3096160be1e626bd011224914b5ada0c7107ff',
        'liveSecKey'    =>'sk_live_3bca78c0aeddda528e4c1dfcd8e9d6129eb99b4d',
        'livePubKey'    =>'pk_live_7091a927346051cb11fe8cff64f32f783e2a3bdd',
        'live'          =>false,
        'url'           =>'https://api.paystack.co/'
    ]
];
