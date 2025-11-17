<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Theme extends BaseClient {

    public function all($params = []) {
        return $this->request('/themes.json', 'GET', $params);
    }

    public function get($id) {
        return $this->request("/themes/{$id}.json");
    }

    // Theme file listing
    public function getFiles($id, $params = []) {
        return $this->request("/themes/{$id}/files.json", 'GET', $params);
    }

    // Single file retrieval - expects query param or body to include file path
    public function getFile($id, $params = []) {
        return $this->request("/themes/{$id}/files/file.json", 'GET', $params);
    }

    public function createFile($id, $data) {
        return $this->request("/themes/{$id}/files.json", 'POST', $data);
    }

    public function updateFile($id, $data) {
        return $this->request("/themes/{$id}/files/file.json", 'PUT', $data);
    }

    public function deleteFile($id, $data) {
        return $this->request("/themes/{$id}/files/file.json", 'DELETE', $data);
    }
}
?>
