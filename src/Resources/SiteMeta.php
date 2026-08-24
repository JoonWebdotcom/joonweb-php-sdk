<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class SiteMeta extends BaseClient {
    
    public function all($params = []) {
        return $this->request('/sitemeta', 'GET', $params);
    }
    
    public function get($id) {
        return $this->request("/sitemeta/{$id}");
    }
    
    public function create($data) {
        // SiteMeta uses FLAT payload, not wrapped!
        return $this->request('/sitemeta', 'POST', $data);
    }
    
    public function update($id, $data) {
        return $this->request("/sitemeta/{$id}", 'PUT', $data);
    }
    
    public function delete($id) {
        return $this->request("/sitemeta/{$id}", 'DELETE');
    }
    
    public function getByType($type, $subtype = null) {
        $path = $subtype ? "/sitemeta/type/{$type}/{$subtype}" : "/sitemeta/type/{$type}";
        return $this->request($path, 'GET');
    }
    
    public function updateByType($type, $subtype, $data) {
        $path = $subtype ? "/sitemeta/type/{$type}/{$subtype}" : "/sitemeta/type/{$type}";
        return $this->request($path, 'PUT', $data);
    }
    
    public function deleteByType($type, $subtype = null) {
        $path = $subtype ? "/sitemeta/type/{$type}/{$subtype}" : "/sitemeta/type/{$type}";
        return $this->request($path, 'DELETE');
    }
}
