<?php

namespace local_certhub;

defined('MOODLE_INTERNAL') || die();


class Secureconfig {
    const CIPHER = 'aes-256-cbc';

    private static function getKey() {
        $siteid = get_site_identifier(); // Site-specific
        return hash('sha256', $siteid, true); // 256-bit key
    }

    public static function encrypt($plaintext) {
        $iv = random_bytes(openssl_cipher_iv_length(self::CIPHER));
        $ciphertext = openssl_encrypt($plaintext, self::CIPHER, self::getKey(), 0, $iv);
        return base64_encode($iv . $ciphertext);
    }

    public static function decrypt($data) {
        $raw = base64_decode($data);
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = substr($raw, 0, $ivlen);
        $ciphertext = substr($raw, $ivlen);
        return openssl_decrypt($ciphertext, self::CIPHER, self::getKey(), 0, $iv);
    }

    public static function setEncryptedConfig($name, $value) {
        set_config($name, self::encrypt($value), 'local_certhub');
    }

    public static function getDecryptedConfig($name) {
        $raw = get_config('local_certhub', $name);
        return $raw ? self::decrypt($raw) : null;
    }
}
