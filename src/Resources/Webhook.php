<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Webhook extends BaseClient {
    public function all($params = []) {
        return $this->request('/webhooks', 'GET', $params);
    }
    public function get($id) {
        return $this->request("/webhooks/{$id}");
    }
    public function create($data) {
        return $this->request('/webhooks', 'POST', ['webhook' => $data]);
    }
    public function update($id, $data) {
        return $this->request("/webhooks/{$id}", 'PUT', ['webhook' => $data]);
    }
    public function delete($id) {
        return $this->request("/webhooks/{$id}", 'DELETE');
    }
}
