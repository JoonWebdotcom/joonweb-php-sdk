<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Checkout extends BaseClient {

    public function all($params = []) {
        return $this->request('/checkouts.json', 'GET', $params);
    }

    public function count($params = []) {
        return $this->request('/checkouts/count.json', 'GET', $params);
    }

    public function get($id) {
        return $this->request("/checkouts/{$id}.json");
    }

    public function create($data) {
        return $this->request('/checkouts.json', 'POST', ['checkout' => $data]);
    }

    public function update($id, $data) {
        return $this->request("/checkouts/{$id}.json", 'PUT', ['checkout' => $data]);
    }

    public function complete($id, $data = []) {
        return $this->request("/checkouts/{$id}/complete.json", 'POST', $data);
    }
}
?>
