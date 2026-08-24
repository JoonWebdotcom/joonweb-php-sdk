<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Customer extends BaseClient {
    public function all($params = []) {
        return $this->request('/customers', 'GET', $params);
    }
    public function get($id) {
        return $this->request("/customers/{$id}");
    }
    public function create($data) {
        return $this->request('/customers', 'POST', ['customer' => $data]);
    }
    public function update($id, $data) {
        return $this->request("/customers/{$id}", 'PUT', ['customer' => $data]);
    }
    public function delete($id) {
        return $this->request("/customers/{$id}", 'DELETE');
    }
    public function count($params = []) {
        return $this->request('/customers/count', 'GET', $params);
    }
}
