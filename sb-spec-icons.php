<?php

/**
 * Plugin Name: Silverback Product Specification Icons
 * Description: Add specification icons to your WooCommerce products
 * Author: Werner C. Bessinger
 * Version: 1.0.0
 */

//  access control
if (!defined('ABSPATH')) {
    exit;
}

// globals
define('SBSI_PATH', plugin_dir_path(__FILE__));
define('SBSI_URL', plugin_dir_url(__FILE__));

// classes
require_once SBSI_PATH . 'classes/SBSI_Back.php';
require_once SBSI_PATH . 'classes/SBSI_Front.php';
