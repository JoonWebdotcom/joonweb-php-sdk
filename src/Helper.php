<?php
namespace JoonWeb;

class Helper {
    
    /**
     * Securely verify HMAC signature to ensure the request is from JoonWeb.
     * 
     * @param array $params The request parameters (typically $_GET)
     * @param string $secret The API secret key
     * @return bool True if HMAC is valid, false otherwise
     */
    public static function verifyHmac(array $params, string $secret): bool {
        $hmac = $params['hmac'] ?? '';
        unset($params['hmac']);
        
        ksort($params);
        $message = http_build_query($params);
        $calculated_hmac = hash_hmac('sha256', $message, $secret);
        
        return hash_equals($hmac, $calculated_hmac);
    }
}
