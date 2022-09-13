<?php
/*
Plugin Name: Boka Core
Plugin URI: https://themetim.com/
Description: Boka core contains all the functionality of boka theme.
Author: themetim
Author URI: https://themetim.com
Version: 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;
define( 'BOKA_VERSION', '1.0.0' );
define( 'BOKA_PLUG_DIR', dirname(__FILE__).'/' );
define('BOKA_PLUG_URL', plugin_dir_url(__FILE__));

function bringback_framework_init_check() {
    require_once BOKA_PLUG_DIR .'/includes/index.php';
    require_once BOKA_PLUG_DIR .'/vendor/index.php';
}

add_action( 'plugins_loaded', 'bringback_framework_init_check' );

if (class_exists('ELEMENTOR')){
    add_action( 'template_redirect', function() {
        $instance = \Elementor\Plugin::$instance->templates_manager->get_source( 'local' );
        remove_action( 'template_redirect', [ $instance, 'block_template_frontend' ] );
    }, 9 );
}

?>