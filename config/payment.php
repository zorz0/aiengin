<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Currency which have decimals
    |--------------------------------------------------------------------------
    */

    'currency_decimals' => ['AUD', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'MXN', 'NZD', 'NOK', 'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD'],

    /*
    |--------------------------------------------------------------------------
    | Currency which supported by paypal subscription'
    |--------------------------------------------------------------------------
    */

    'paypal_currency_subscription' => ['AUD', 'BRL', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'INR', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK', 'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD'],

    'gateways' => [
        'stripe' => [
            'enable' => true,
            'name' => 'Stripe',
            'color' => 'white',
            'secret_key' => 'sk_test_SmE22x1tMizyEzTlgrMSVg4M',
            'subscriptionLink' => 'frontend.stripe.subscription.authorization',
            'buttonColor' => '#635bff',
            'buttonIcon' => '<svg width="24px" height="24px" fill="#ffffff" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title>Stripe icon</title><path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z"></path></g></svg>',
        ],
        'paypal' => [
            'enable' => true,
            'name' => 'Paypal',
            'color' => '#03c3f7',
            'sandbox' => true,
            'public_key' => 'AWp0joHL1gH-dxMVdKt6wEfHs39hhJPZ9iDSRHLIi1GWzHNhzHy70lbZTY4qAX3DLwLE52w__fp99yC3',
            'secret_key' => 'EMBscliWmiiysZshUW4i0RHiUiHbJB-hlPNyulOYn1ON_Wd9k3eywJ4Kwxam9-92rHxlCZEXVeT1hb0b',
            'subscriptionLink' => 'frontend.paypal.subscription.authorization',
            'buttonColor' => '#ffcf00',
            'buttonIcon' => '<svg width="24px" height="24px" viewBox="-3.5 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Paypal-color</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Color-" transform="translate(-804.000000, -660.000000)" fill="#ffffff"> <path d="M838.91167,663.619443 C836.67088,661.085983 832.621734,660 827.440097,660 L812.404732,660 C811.344818,660 810.443663,660.764988 810.277343,661.801472 L804.016136,701.193856 C803.892151,701.970844 804.498465,702.674333 805.292267,702.674333 L814.574458,702.674333 L816.905967,688.004562 L816.833391,688.463555 C816.999712,687.427071 817.894818,686.662083 818.95322,686.662083 L823.363735,686.662083 C832.030541,686.662083 838.814901,683.170138 840.797138,673.069296 C840.856106,672.7693 840.951363,672.194809 840.951363,672.194809 C841.513828,668.456868 840.946827,665.920407 838.91167,663.619443 Z M843.301017,674.10803 C841.144899,684.052874 834.27133,689.316292 823.363735,689.316292 L819.408334,689.316292 L816.458414,708 L822.873846,708 C823.800704,708 824.588458,707.33101 824.733611,706.423525 L824.809211,706.027531 L826.284927,696.754676 L826.380183,696.243184 C826.523823,695.335698 827.313089,694.666708 828.238435,694.666708 L829.410238,694.666708 C836.989913,694.666708 842.92604,691.611256 844.660308,682.776394 C845.35583,679.23045 845.021677,676.257496 843.301017,674.10803 Z" id="Paypal"> </path> </g> </g> </g></svg>',
        ],
        'flutterwave' => [
            'enable' => true,
            'name' => 'FlutterWave',
            'color' => '#f5a623',
            'environment' => 'staging', //This can be staging or live.
            'public_key' => 'FLWPUBK_TEST-8f3d2d97fd7e3719ddb4dcf493b84a6b-X',
            'secret_key' => 'FLWSECK_TEST-1f4620f9e5aeaeeaf7662cbbeaa8da2b-X',
            'encryption' => 'FLWSECK_TESTc0ce68f908ed',
            'subscriptionLink' => 'frontend.flutterwave.subscription.authorization',
            'buttonColor' => '#0f1c70',
            'buttonIcon' => '<svg fill="none" height="24" viewBox="0 0 34 34" width="24" xmlns="http://www.w3.org/2000/svg" class="flw" data-v-7125cfaa=""> <path clip-rule="evenodd" d="M24.9077 0.266665C40.0134 -2 30.3457 10.8667 25.6462 14.4667C28.8687 16.9333 32.1584 20.4 33.5683 24.3333C36.1866 31.5333 29.7415 32.6 24.9077 30.8C19.6039 28.9333 14.9043 24.9333 11.8161 20.2667C10.9433 20.2667 10.0034 20.1333 9.13062 19.8667C10.8762 24.8 11.6147 29.8667 11.1447 34C11.1447 25.6667 7.18366 17.4 1.47706 10.5333C-0.537031 8.13333 1.5442 6.33333 3.35688 8.66667C4.57713 10.3565 5.69794 12.115 6.7137 13.9333C8.66066 7.13333 18.3283 1.2 24.9077 0.266665ZM22.7593 12.5333C25.7133 10.7333 34.7096 1.06667 26.3175 1.93333C21.4837 2.46667 15.6429 6.93333 13.2259 9.8C16.5828 9.4 20.0067 10.8667 22.7593 12.5333ZM13.1588 11.9333C15.4414 11.7333 17.9255 12.9333 19.8053 14.1333C17.9926 15 15.9785 15.5333 13.8973 15.6667C10.809 15.6667 10.2048 12.2 13.1588 11.9333ZM14.4344 20C17.1199 23 20.8124 25.9333 24.7734 27C27.056 27.6 29.6072 27.3333 28.6673 24.0667C27.7274 21.0667 25.3105 18.4 22.9607 16.4C22.2894 16.8667 21.5509 17.3333 20.8124 17.6667C18.7983 18.8 16.6499 19.6 14.4344 20Z" fill-rule="evenodd" fill="#f5a623"></path></svg>',
        ],
        'bankwire' => [
            'enable' => true,
            'name' => 'Bank Wire',
            'color' => 'white',
            'subscriptionLink' => 'frontend.bankwire.subscription.authorization',
            'buttonColor' => 'black',
            'buttonIcon' => '<svg fill="white" width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" xml:space="preserve"><polygon points="474.417,143.926 245.384,0 15.583,143.711 31.865,169.722 245.353,36.246 458.073,169.922 	"/><rect x="376.297" y="183.073" width="30.691" height="240.45"/><rect x="229.654" y="183.073" width="30.691" height="240.45"/><rect x="83.012" y="183.073" width="30.691" height="240.45"/><rect x="25.021" y="459.309" width="439.943" height="30.691"/></svg>',
        ],
        'payhere' => [
            'enable' => true,
            'name' => 'PayHere',
            'color' => '#03c3f7',
            'base_url' => 'https://sandbox.payhere.lk/',
            'merchant_id' => '1215571',
            'merchant_secret_key' => '4Uptukjbnne8bJsJvbjm3s4KBokTjb2F28LUrAxTLIwM',
            'business_app_id' => '4OVx3M7cW3s4J9Lyvx2auP3Xj ',
            'business_app_secret_key' => '4UopTb0XHKm4fVD4gCkp064p9PSYrYJN88MMya8VRFWW',
            'subscriptionLink' => 'frontend.payhere.subscription.authorization',
            'buttonColor' => '#2447d7',
            'buttonIcon' => '<svg width="24"  height="24" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><path fill="#024DC9" opacity="1.000000" stroke="none" 	d="M48.004738,65.000000 	C32.003754,65.000000 16.503887,65.000000 1.003018,65.000000 	C1.002012,43.668194 1.002012,22.336390 1.001006,1.003438 	C22.331619,1.002292 43.663239,1.002292 64.996140,1.001146 	C64.997429,22.331430 64.997429,43.662861 64.998718,64.997147 	C59.501953,65.000000 54.003902,65.000000 48.004738,65.000000 M19.953543,27.698862 	C19.260048,28.785269 17.998320,29.855288 17.966434,30.960777 	C17.777277,37.519253 17.873056,44.085945 17.873056,50.810596 	C22.615410,50.810596 26.688992,50.810596 31.123289,50.810596 	C31.123289,48.171223 31.123289,45.745197 31.123289,43.455395 	C34.407585,42.373173 37.408760,41.596737 40.237316,40.409161 	C46.659954,37.712593 50.118168,29.361574 47.391582,23.547266 	C43.915413,16.134518 37.187302,13.202198 30.197695,16.176456 	C26.257891,15.630297 22.318085,15.084138 17.786077,14.455884 	C18.449167,19.486858 15.721883,23.952978 19.953543,27.698862 z"/><path fill="#F7F8FC" opacity="1.000000" stroke="none" 	d="M31.030495,16.416594 	C37.187302,13.202198 43.915413,16.134518 47.391582,23.547266 	C50.118168,29.361574 46.659954,37.712593 40.237316,40.409161 	C37.408760,41.596737 34.407585,42.373173 31.123289,43.455395 	C31.123289,45.745197 31.123289,48.171223 31.123289,50.810596 	C26.688992,50.810596 22.615410,50.810596 17.873056,50.810596 	C17.873056,44.085945 17.777277,37.519253 17.966434,30.960777 	C17.998320,29.855288 19.260048,28.785269 20.495760,27.290741 	C24.368816,23.393946 27.699656,19.905270 31.030495,16.416594 z"/><path fill="#EAECF7" opacity="1.000000" stroke="none" 	d="M30.614094,16.296524 	C27.699656,19.905270 24.368816,23.393946 20.724804,26.955662 	C15.721883,23.952978 18.449167,19.486858 17.786077,14.455884 	C22.318085,15.084138 26.257891,15.630297 30.614094,16.296524 z"/></svg>',
        ],
        'paystack' => [
            'enable' => true,
            'name' => 'PayStack',
            'color' => '#03c3f7',
            'secret_key' => 'sk_test_a98b5265de9738a9d7db3928ba9dceb6fd4add01',
            'subscriptionLink' => 'frontend.paystack.subscription.authorization',
            'buttonColor' => '#03c3f7',
            'buttonIcon' => '<svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><defs></defs><g clip-path="url(#clip0)"><path d="M22.32 2.663H1.306C.594 2.663 0 3.263 0 3.985v2.37c0 .74.594 1.324 1.307 1.324h21.012c.73 0 1.307-.602 1.324-1.323V4.002c0-.738-.594-1.34-1.323-1.34zm0 13.192H1.306a1.3 1.3 0 00-.924.388 1.33 1.33 0 00-.383.935v2.37c0 .74.594 1.323 1.307 1.323h21.012c.73 0 1.307-.584 1.324-1.322v-2.371c0-.739-.594-1.323-1.323-1.323zm-9.183 6.58H1.307c-.347 0-.68.139-.924.387a1.33 1.33 0 00-.383.935v2.37c0 .74.594 1.323 1.307 1.323H13.12c.73 0 1.307-.6 1.307-1.322v-2.371a1.29 1.29 0 00-1.29-1.323zM23.643 9.258H1.307c-.347 0-.68.14-.924.387a1.33 1.33 0 00-.383.936v2.37c0 .739.594 1.323 1.307 1.323h22.32c.73 0 1.306-.601 1.306-1.323v-2.37a1.301 1.301 0 00-1.29-1.323z" fill="white"></path></g><defs><clipPath id="clip0"><path fill="#fff" d="M0 0h157v28H0z"></path></clipPath></defs></svg>',
        ]
    ]
];
