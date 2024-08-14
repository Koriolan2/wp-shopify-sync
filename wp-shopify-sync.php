<?php
/**
 * Plugin Name: WP Shopify Sync
 * Description: A plugin to sync Shopify products with WordPress database.
 * Version: 1.2
 * Author: Юрій Книш aka Юрій Козьмін
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include required files
include_once plugin_dir_path(__FILE__) . 'includes/class-shopify-sync.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-shopify-cron.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-shopify-database.php';

// Initialize the plugin
function wp_shopify_sync_init() {
    $shopify_sync = new Shopify_Sync();
    $shopify_sync->init();

    $shopify_cron = new Shopify_Cron();
    $shopify_cron->schedule_event();
}
add_action('plugins_loaded', 'wp_shopify_sync_init');

// Activation hook
function wp_shopify_sync_activate() {
    Shopify_Database::create_table();
    Shopify_Cron::schedule_event();
}
register_activation_hook(__FILE__, 'wp_shopify_sync_activate');

// Deactivation hook
function wp_shopify_sync_deactivate() {
    Shopify_Cron::clear_scheduled_event();
}
register_deactivation_hook(__FILE__, 'wp_shopify_sync_deactivate');
