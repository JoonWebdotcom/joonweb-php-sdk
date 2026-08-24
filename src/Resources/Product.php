<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Product extends BaseClient {
    
    public function all($params = []) {
        return $this->request('/products', 'GET', $params);
    }
    
    public function get($id) {
        return $this->request("/products/{$id}");
    }
    
    public function create($data) {
        // Products are wrapped in "product" object
        return $this->request('/products', 'POST', ['product' => $data]);
    }
    
    public function update($id, $data) {
        return $this->request("/products/{$id}", 'PUT', ['product' => $data]);
    }
    
    public function delete($id) {
        return $this->request("/products/{$id}", 'DELETE');
    }
    
    public function count($params = []) {
        return $this->request('/products/count', 'GET', $params);
    }
}
