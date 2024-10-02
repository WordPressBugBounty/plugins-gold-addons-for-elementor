<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://goldaddons.com/
 * @since      1.2.6
 *
 * @package    GoldAddons For Elementor
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

/**
 * Delete plugin options when uninstalling.
 */
delete_option('gold_addons_activate_data_sent');
delete_option('gold_addons_deactivate_data_sent');
delete_option('_goldaddons_license');
