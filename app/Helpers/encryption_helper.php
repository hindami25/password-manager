<?php

function encrypt($data, $key = null)
{
    if ($key === null) {
        $key = session()->get('master_key');
    }

    // Generate a random IV
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Encrypt the data with the IV
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    // Concatenate the IV with the encrypted data and base64 encode it
    return base64_encode($iv . $encrypted);
}

function decrypt($data, $key = null)
{
    if ($key === null) {
        $key = session()->get('master_key');
    }

    // Decode the base64 encoded data
    $data = base64_decode($data);

    // Extract the IV from the data
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $iv_length);

    // Extract the encrypted data from the remaining data
    $encrypted = substr($data, $iv_length);

    // Decrypt the data using the IV
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}
