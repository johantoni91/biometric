<?php

return [
    'secret' => env('NOCAPTCHA_SECRET'),
    'sitekey' => env('NOCAPTCHA_SITEKEY'),
    'default'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => true,  //Enable Math Captcha
        'expire'    => 60,    //Captcha expiration
    ],
    'options' => [
        'timeout' => 30,
    ],
];
