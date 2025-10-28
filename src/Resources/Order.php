<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Order extends BaseClient {
    
    public function all($params = []) {
        return $this->request('/orders.json', 'GET', $params);
    }
    
    public function get($id) {
        return $this->request("/orders/{$id}.json");
    }
    
    public function count($params = []) {
        return $this->request('/orders/count.json', 'GET', $params);
    }
}
?>