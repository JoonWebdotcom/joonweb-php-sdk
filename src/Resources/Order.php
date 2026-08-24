<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Order extends BaseClient {
    
    public function all($params = []) {
        return $this->request('/orders', 'GET', $params);
    }
    
    public function get($id) {
        return $this->request("/orders/{$id}");
    }
    
    public function create($data) {
        return $this->request('/orders', 'POST', ['order' => $data]);
    }
    
    public function update($id, $data) {
        return $this->request("/orders/{$id}", 'PUT', ['order' => $data]);
    }
    
    public function delete($id) {
        return $this->request("/orders/{$id}", 'DELETE');
    }
    
    public function count($params = []) {
        return $this->request('/orders/count', 'GET', $params);
    }
}
