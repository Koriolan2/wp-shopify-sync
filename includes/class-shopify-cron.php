<?php

class Shopify_Cron {
    public static function schedule_event() {
        if (!wp_next_scheduled('shopify_sync_event')) {
            wp_schedule_event(time(), 'five_minutes', 'shopify_sync_event');
        }
    }

    public static function clear_scheduled_event() {
        $timestamp = wp_next_scheduled('shopify_sync_event');
        wp_unschedule_event($timestamp, 'shopify_sync_event');
    }
}

// Add custom cron schedule
add_filter('cron_schedules', function($schedules) {
    $schedules['five_minutes'] = array(
        'interval' => 300,
        'display'  => __('Every Five Minutes')
    );

    return $schedules;
});
