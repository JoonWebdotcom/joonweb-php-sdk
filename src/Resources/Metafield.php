<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Metafield extends BaseClient {
    
    public function all($params = []) {
        return $this->request('/metafields', 'GET', $params);
    }
    
    public function get($id) {
        return $this->request("/metafields/{$id}");
    }
    
    public function create($data) {
        // Metafields use FLAT payload
        return $this->request('/metafields', 'POST', $data);
    }
    
    public function update($id, $data) {
        return $this->request("/metafields/{$id}", 'PUT', $data);
    }
    
    public function delete($id) {
        return $this->request("/metafields/{$id}", 'DELETE');
    }
}
