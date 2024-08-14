<?php

class Shopify_Sync {
    private $api_url = 'https://wsdledinc.myshopify.com/admin/api/2024-04/products.json?limit=250';
    private $access_token = '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';

    public function init() {
        add_action('shopify_sync_event', array($this, 'sync_products'));
    }

    public function sync_products() {
        $products = $this->get_shopify_products();

        if (!empty($products)) {
            Shopify_Database::clear_table();
            Shopify_Database::insert_products($products);
        }
    }

    private function get_shopify_products() {
        $headers = array(
            'Content-Type: application/json',
            'X-Shopify-Access-Token: ' . $this->access_token
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
