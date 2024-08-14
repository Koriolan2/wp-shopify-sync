<?php

class Shopify_Database {
    private static $table_name = 'wp_shopify_products';

    public static function create_table() {
        global $wpdb;
        $table_name = self::$table_name;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            product_id BIGINT(20) NOT NULL,
            title TEXT NOT NULL,
            body_html LONGTEXT NOT NULL,
            vendor TEXT NOT NULL,
            product_type TEXT NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function clear_table() {
        global $wpdb;
        $table_name = self::$table_name;
        $wpdb->query("TRUNCATE TABLE $table_name");
    }

    public static function insert_products($products) {
        global $wpdb;
        $table_name = self::$table_name;

        foreach ($products['products'] as $product) {
            $wpdb->insert(
                $table_name,
                array(
                    'product_id'   => $product['id'],
                    'title'        => $product['title'],
                    'body_html'    => $product['body_html'],
                    'vendor'       => $product['vendor'],
                    'product_type' => $product['product_type'],
                    'created_at'   => $product['created_at'],
                    'updated_at'   => $product['updated_at']
                )
            );
        }
    }
}
