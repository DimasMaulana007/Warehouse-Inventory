<?php
function encrypt_url($string) {
    $key = $_ENV['ENCRYPTION_KEY'];
    return urlencode(base64_encode(openssl_encrypt($string, "AES-128-ECB", $key, 0)));
}

function decrypt_url($encrypted) {
    $key = $_ENV['ENCRYPTION_KEY'];
    $encrypted = urldecode($encrypted);
    return openssl_decrypt(base64_decode($encrypted), "AES-128-ECB", $key, 0);
}
?>