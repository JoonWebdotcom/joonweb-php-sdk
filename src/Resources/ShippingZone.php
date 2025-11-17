<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class ShippingZone extends BaseClient {

    public function all($params = []) {
        return $this->request('/shipping_zones.json', 'GET', $params);
    }
}
?>
