<?php
namespace JoonWeb\Resources;

use JoonWeb\Clients\BaseClient;

class Billing extends BaseClient {
    public function createCharge($data) {
        return $this->request('/create_app_billing', 'POST', ['charge' => $data]);
    }
    public function getCharge($id) {
        return $this->request("/app_billings/{$id}");
    }
    public function createSubscription($data) {
        return $this->request('/recurring_application_charges', 'POST', ['recurring_charge' => $data]);
    }
    public function getSubscription($id) {
        return $this->request("/recurring_application_charges/{$id}");
    }
    public function cancelSubscription($id) {
        return $this->request("/recurring_application_charges/{$id}", 'DELETE');
    }
}
