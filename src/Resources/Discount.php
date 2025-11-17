<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Discount extends BaseClient {

    public function all($params = []) {
        return $this->request('/discounts.json', 'GET', $params);
    }

    public function get($id) {
        return $this->request("/discounts/{$id}.json");
    }

    public function showByCode($code) {
        return $this->request("/discounts/code/{$code}.json", 'GET');
    }

    public function create($data) {
        return $this->request('/discounts.json', 'POST', ['discount' => $data]);
    }

    public function update($id, $data) {
        return $this->request("/discounts/{$id}.json", 'PUT', ['discount' => $data]);
    }

    public function delete($id) {
        return $this->request("/discounts/{$id}.json", 'DELETE');
    }
}
?>
