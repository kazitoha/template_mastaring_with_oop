<?php
function base_url($path = '')
{
    return 'http://localhost/template_master/' . $path;
}

function encrypt($data, $key = 'your_secret_key')
{
    $cipher = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = random_bytes($iv_length);

    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt($data, $key = 'your_secret_key')
{
    $cipher = "AES-128-CTR";

    $decoded = base64_decode($data);
    list($encrypted_data, $iv) = explode('::', $decoded, 2);

    return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
}
