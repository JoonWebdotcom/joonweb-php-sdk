<?php
namespace JoonWeb\Clients;

use JoonWeb\Context;
use Exception;

class BaseClient {
    protected $access_token;
    protected $site_domain;
    protected $timeout = 30;
    
    public function __construct($access_token = null, $site_domain = null) {
        $this->access_token = $access_token;
        $this->site_domain = $site_domain;
    }
    
    public function setAccessToken($token) {
        $this->access_token = $token;
        return $this;
    }
    
    public function setSiteDomain($domain) {
        $this->site_domain = $domain;
        return $this;
    }
    
    protected function request($endpoint, $method = 'GET', $data = []) {
        if (!$this->site_domain || !$this->access_token) {
            throw new Exception("Site domain and access token must be configured before making requests.");
        }

        $url = "https://{$this->site_domain}/api/admin/" . Context::$API_VERSION . $endpoint;
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: ' . Context::$APP_NAME . '/Joonweb-PHP-SDK',
            'X-Joonweb-Access-Token: ' . $this->access_token
        ];
        
        if ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($data)) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if (!empty($data)) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        if ($response === false) {
            throw new Exception("cURL Error: " . $curl_error);
        }

        $result = json_decode($response, true);
        
        if ($http_code >= 400) {
            $errorMsg = 'Unknown error';
            if (isset($result['error'])) {
                if (is_array($result['error'])) {
                    $errorMsg = $result['error']['message'] ?? json_encode($result['error']);
                } else {
                    $errorMsg = $result['error'];
                }
            }
            throw new Exception("API error {$http_code}: " . $errorMsg, $http_code);
        }
        
        return $result;
    }
}
