<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Webhook extends BaseClient {
    
    public function all($params = []) {
        return $this->request('/webhooks.json', 'GET', $params);
    }
    
    public function get($id) {
        return $this->request("/webhooks/{$id}.json");
    }
    
    public function create($data) {
        return $this->request('/webhooks.json', 'POST', ['webhook' => $data]);
    }
    
    public function update($id, $data) {
        return $this->request("/webhooks/{$id}.json", 'PUT', ['webhook' => $data]);
    }
    
    public function delete($id) {
        return $this->request("/webhooks/{$id}.json", 'DELETE');
    }
}
?>