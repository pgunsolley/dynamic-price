<?php

return [
    'RecaptchaV3' => [
        /*
         * The secret key string
         */
        'secretKey' => null,

        /*
         * The site key string
         */
        'siteKey' => null,

        /*
         * A flag to enable or disable sending the requester's 
         * IP to the recaptcha service for enhanced results.
         */
        'sendRemoteIp' => true,
    ],
];
