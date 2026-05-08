<?php

return [
    'RecaptchaV3' => [
        /*
         * Configuration for included services
         */
        'Services' => [
            /*
             * Service for making requests with the recaptcha service
             */
            'RecaptchaV3' => [
                'secretKey' => '',
                'siteKey' => '',
            ],
        ],

        /*
         * Configuration for included middleware
         */
        'Middleware' => [
            'RecaptchaV3' => [
                /*
                 * A flag to enable or disable sending the requester's 
                 * IP to the recaptcha service for enhanced results.
                 */
                'sendRemoteIp' => true,
            ],
        ],

        /*
         * The database connection name for models.
         * The connection must be configured in the host application.
         */
        'connection' => '',
    ],
];
