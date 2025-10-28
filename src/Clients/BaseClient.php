<?php
namespace JoonWeb\Clients;

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
        $url = "https://{$this->site_domain}/api/admin/" . JOONWEB_API_VERSION . $endpoint;
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: ' . APP_NAME . '/v' . APP_VERSION,
            'X-JoonWeb-Access-Token: ' . $this->access_token
        ];
        
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
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if ($http_code >= 400) {
            throw new \Exception("API error {$http_code}: " . ($result['error'] ?? 'Unknown error'));
        }
        
        return $result;
    }
}
?>