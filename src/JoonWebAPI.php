<?php
namespace JoonWeb;

use JoonWeb\Resources\Product;
use JoonWeb\Resources\Order;
use JoonWeb\Resources\Customer;
use JoonWeb\Resources\Collection;
use JoonWeb\Resources\SiteMeta;
use JoonWeb\Resources\Metafield;
use JoonWeb\Resources\Webhook;
use JoonWeb\Resources\Billing;

class JoonWebAPI {
    private $access_token;
    private $site_domain;
    
    public $product;
    public $order;
    public $customer;
    public $collection;
    public $sitemeta;
    public $metafield;
    public $webhook;
    public $billing;
    
    public function __construct($access_token = null, $site_domain = null) {
        $this->access_token = $access_token;
        $this->site_domain = $site_domain;
        
        // Initialize resource clients
        $this->product = new Product($access_token, $site_domain);
        $this->order = new Order($access_token, $site_domain);
        $this->customer = new Customer($access_token, $site_domain);
        $this->collection = new Collection($access_token, $site_domain);
        $this->sitemeta = new SiteMeta($access_token, $site_domain);
        $this->metafield = new Metafield($access_token, $site_domain);
        $this->webhook = new Webhook($access_token, $site_domain);
        $this->billing = new Billing($access_token, $site_domain);
    }
    
    public function setAccessToken($token) {
        $this->access_token = $token;
        
        $this->product->setAccessToken($token);
        $this->order->setAccessToken($token);
        $this->customer->setAccessToken($token);
        $this->collection->setAccessToken($token);
        $this->sitemeta->setAccessToken($token);
        $this->metafield->setAccessToken($token);
        $this->webhook->setAccessToken($token);
        $this->billing->setAccessToken($token);

        return $this;
    }
    
    public function setSiteDomain($domain) {
        $this->site_domain = $domain;
        
        $this->product->setSiteDomain($domain);
        $this->order->setSiteDomain($domain);
        $this->customer->setSiteDomain($domain);
        $this->collection->setSiteDomain($domain);
        $this->sitemeta->setSiteDomain($domain);
        $this->metafield->setSiteDomain($domain);
        $this->webhook->setSiteDomain($domain);
        $this->billing->setSiteDomain($domain);

        return $this;
    }
}
