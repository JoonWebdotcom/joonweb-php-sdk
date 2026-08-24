<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Collection extends BaseClient {
    public function all($params = []) {
        return $this->request('/custom_collections', 'GET', $params);
    }
    public function get($id) {
        return $this->request("/custom_collections/{$id}");
    }
    public function create($data) {
        return $this->request('/custom_collections', 'POST', ['custom_collection' => $data]);
    }
    public function update($id, $data) {
        return $this->request("/custom_collections/{$id}", 'PUT', ['custom_collection' => $data]);
    }
    public function delete($id) {
        return $this->request("/custom_collections/{$id}", 'DELETE');
    }
}
