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

    /**
     * Generate the embedded app URL to redirect back into the JoonWeb Admin.
     * 
     * @param string $siteHash The unique site_hash from the OAuth callback request
     * @param string $appSlug The app_slug (often the client_id/api_key)
     * @return string The URL to redirect the user to
     */
    public static function getEmbeddedAppUrl(string $siteHash, string $appSlug): string {
        $baseUrl = "https://accounts.joonweb.com/site/";
        return $baseUrl . '?sitehash=' . urlencode($siteHash) . '&apps&' . urlencode($appSlug);
    }
}
