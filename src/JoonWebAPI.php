<?php
namespace JoonWeb;

use JoonWeb\Resources\Product;
use JoonWeb\Resources\Order;
use JoonWeb\Resources\Webhook;
use JoonWeb\Resources\Site;

class JoonWebAPI {
    private $access_token;
    private $site_domain;
    
    public $product;
    public $order;
    public $webhook;
    public $site;
    public $customer;
    public $discount;
    public $checkout;
    public $shippingZone;
    public $theme;
    
    public function __construct($access_token = null, $site_domain = null) {
        $this->access_token = $access_token;
        $this->site_domain = $site_domain;
        
        // Initialize resource clients
    $this->product = new Product($access_token, $site_domain);
    $this->order = new Order($access_token, $site_domain);
    $this->webhook = new Webhook($access_token, $site_domain);
    $this->site = new Site($access_token, $site_domain);
    $this->customer = new \JoonWeb\Resources\Customer($access_token, $site_domain);
    $this->discount = new \JoonWeb\Resources\Discount($access_token, $site_domain);
    $this->checkout = new \JoonWeb\Resources\Checkout($access_token, $site_domain);
    $this->shippingZone = new \JoonWeb\Resources\ShippingZone($access_token, $site_domain);
    $this->theme = new \JoonWeb\Resources\Theme($access_token, $site_domain);
    }
    
    public function setAccessToken($token) {
        $this->access_token = $token;
        
        // Update all resource clients
    $this->product->setAccessToken($token);
    $this->order->setAccessToken($token);
    $this->webhook->setAccessToken($token);
    $this->site->setAccessToken($token);
    $this->customer->setAccessToken($token);
    $this->discount->setAccessToken($token);
    $this->checkout->setAccessToken($token);
    $this->shippingZone->setAccessToken($token);
    $this->theme->setAccessToken($token);

        return $this;
    }
    
    public function setSiteDomain($domain) {
        $this->site_domain = $domain;
        
        // Update all resource clients
    $this->product->setSiteDomain($domain);
    $this->order->setSiteDomain($domain);
    $this->webhook->setSiteDomain($domain);
    $this->site->setSiteDomain($domain);
    $this->customer->setSiteDomain($domain);
    $this->discount->setSiteDomain($domain);
    $this->checkout->setSiteDomain($domain);
    $this->shippingZone->setSiteDomain($domain);
    $this->theme->setSiteDomain($domain);

        return $this;
    }
    
    /**
     * Exchange authorization code for access token
     */
    public function exchangeCodeForToken($code, $site_domain) {
        $url = "https://{$site_domain}/api/admin/" . JOONWEB_API_VERSION . "/oauth/access_token";
        
        $payload = [
            'client_id' => JOONWEB_CLIENT_ID,
            'client_secret' => JOONWEB_CLIENT_SECRET,
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
        
        if ($http_code === 200) {
            return json_decode($response, true);
        }
        
        throw new \Exception("Token exchange failed: HTTP {$http_code}");
    }
}
?>