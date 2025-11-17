<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Customer extends BaseClient {

    public function all($params = []) {
        return $this->request('/customers.json', 'GET', $params);
    }

    public function get($id) {
        return $this->request("/customers/{$id}.json");
    }

    public function create($data) {
        return $this->request('/customers.json', 'POST', ['customer' => $data]);
    }

    public function update($id, $data) {
        return $this->request("/customers/{$id}.json", 'PUT', ['customer' => $data]);
    }

    public function delete($id) {
        return $this->request("/customers/{$id}.json", 'DELETE');
    }

    public function orders($id, $params = []) {
        return $this->request("/customers/{$id}/orders.json", 'GET', $params);
    }

    public function addresses($id, $params = []) {
        return $this->request("/customers/{$id}/addresses.json", 'GET', $params);
    }
}
?>
