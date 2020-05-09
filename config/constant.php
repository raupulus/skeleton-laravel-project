<?php
return [
    'bcrypt_cost' => 9,  ## Coste al codificar en bcrypt


    /*
    |--------------------------------------------------------------------------
    | Google
    |--------------------------------------------------------------------------
    */
    'google_recaptcha_key' => env('GOOGLE_CAPTCHA_KEY'),
    'google_recaptcha_secret' => env('GOOGLE_CAPTCHA_SECRET'),
];
?>
