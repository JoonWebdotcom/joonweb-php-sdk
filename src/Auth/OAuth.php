<?php
namespace JoonWeb\Auth;

use JoonWeb\Context;
use Exception;

class OAuth {
    /**
     * Get the Authorization URL to redirect the user to
     */
    public static function getAuthorizationUrl($site_domain, $scopes = [], $redirect_uri = '') {
        $query = http_build_query([
            'client_id' => Context::$API_KEY,
            'scope' => implode(',', $scopes),
            'redirect_uri' => $redirect_uri,
            'site' => $site_domain
        ]);
        
        return "https://accounts.joonweb.com/oauth/authorize?" . $query;
    }
    
    /**
     * Exchange authorization code for access token
     */
    public static function exchangeCodeForToken($site_domain, $code) {
        $url = "https://{$site_domain}/api/admin/" . Context::$API_VERSION . "/oauth/access_token";
        
        $payload = [
            'client_id' => Context::$API_KEY,
            'client_secret' => Context::$API_SECRET,
            'code' => $code
        ];
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code === 200 || $http_code === 201) {
            return json_decode($response, true);
        }
        
        throw new Exception("Token exchange failed: HTTP {$http_code}");
    }
    
    /**
     * Verify incoming webhook HMAC
     */
    public static function verifyWebhook($payload, $hmac_header) {
        $calculated_hmac = base64_encode(hash_hmac('sha256', $payload, Context::$API_SECRET, true));
        return hash_equals($hmac_header, $calculated_hmac);
    }
}
