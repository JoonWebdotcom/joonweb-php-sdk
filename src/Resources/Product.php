<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Product extends BaseClient {
    
    public function all($params = []) {
        return $this->request('/products.json', 'GET', $params);
    }
    
    public function get($id) {
        return $this->request("/products/{$id}.json");
    }
    
    public function create($data) {
        return $this->request('/products.json', 'POST', ['product' => $data]);
    }
    
    public function update($id, $data) {
        return $this->request("/products/{$id}.json", 'PUT', ['product' => $data]);
    }
    
    public function delete($id) {
        return $this->request("/products/{$id}.json", 'DELETE');
    }
    
    public function count($params = []) {
        return $this->request('/products/count.json', 'GET', $params);
    }
}
?>