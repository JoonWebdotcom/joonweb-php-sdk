<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Site extends BaseClient {
    
    public function get() {
        return $this->request('/site.json');
    }
}
?>