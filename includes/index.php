<?php

if (!defined('ABSPATH')) {
    exit;
}
if (class_exists('ELEMENTOR')){
    return;
}
if (!class_exists('Boka_Elementor_Addons')) :

    /**
     * Main Boka_Elementor_Addons Class
     *
     */
    final class Boka_Elementor_Addons {

        /** Singleton *************************************************************/
        private static $instance;

        /**
         * Main Boka_Elementor_Addons Instance
         *
         * Insures that only one instance of Boka_Elementor_Addons exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         */
        public static function instance() {

            if (!isset(self::$instance) && !(self::$instance instanceof Boka_Elementor_Addons)) {

                self::$instance = new Boka_Elementor_Addons;

                self::$instance->setup_constants();

                self::$instance->includes();

                self::$instance->hooks();

            }
            return self::$instance;
        }

        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         */
        public function __clone() {
            // Cloning instances of the class is forbidden
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'boka'), BOKA_VERSION);
        }

        /**
         * Disable unserializing of the class
         *
         */
        public function __wakeup() {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'boka'), BOKA_VERSION);
        }

        /**
         * Setup plugin constants
         *
         */
        private function setup_constants() {

            // Plugin Folder Path
            if (!defined('Boka_PLUGIN_DIR')) {
                define('Boka_PLUGIN_DIR', plugin_dir_path(__FILE__));
            }

            // Plugin Folder URL
            if (!defined('Boka_PLUGIN_URL')) {
                define('Boka_PLUGIN_URL', plugin_dir_url(__FILE__));
            }

            // Plugin Folder Path
            if (!defined('Boka_ADDONS_DIR')) {
                define('Boka_ADDONS_DIR', plugin_dir_path(__FILE__) . 'elementor-addons/');
            }

        }

        /**
         * Include required files
         *
         */
        private function includes() {


//            require_once Boka_PLUGIN_DIR . 'includes/helper-functions.php';

        }

        /**
         * Load Plugin Text Domain
         *
         * Looks for the plugin translation files in certain directories and loads
         * them to allow the plugin to be localised
         */
        public function load_plugin_textdomain() {


        }

        /**
         * Setup the default hooks and actions
         */
        private function hooks() {

            add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
            add_action('elementor/frontend/after_register_scripts', array($this, 'register_frontend_scripts'), 10);
            add_action('elementor/frontend/after_enqueue_styles', array($this, 'register_frontend_styles'), 10);
            add_action('elementor/editor/before_enqueue_scripts', array($this, 'register_elementor_editor_css'), 10);
            add_action('elementor/init', array($this, 'add_elementor_category'));
            add_action('elementor/widgets/widgets_registered', array($this, 'include_widgets'));
            add_filter( 'elementor/icons_manager/additional_tabs', array($this, 'add_material_icons_tabs' ) );

        }

        public function add_material_icons_tabs( $tabs = array() ) {

            $tabs['bokaicon'] = array(
                'name'          => 'bokaicon',
                'label'         => esc_html__( 'Boka', 'boka' ),
                'labelIcon'     => 'flaticon-check',
                'prefix'        => 'flaticon-',
                'displayPrefix' => 'boka',
                'url'           => Boka_PLUGIN_URL . 'assets/css/boka/icons/flaticon.css',
                'fetchJson'     => Boka_PLUGIN_URL . 'assets/css/boka/icons/boka.json',
                'ver'           => '3.0.1',
            );
            return $tabs;
        } 

        /**
         * Load Frontend Scripts
         *
         */
        public function register_frontend_scripts() {
            foreach( glob( BOKA_PLUG_DIR. 'assets/js/*.js' ) as $file ) {
                $filename = substr($file, strrpos($file, '/') + 1);
                wp_enqueue_script( $filename, Boka_PLUGIN_URL . 'assets/js/'.$filename, array('jquery'), BOKA_VERSION, true);
            }
        }

        public function register_elementor_editor_css() {
            wp_enqueue_style( 'elementor-custom-editor', Boka_PLUGIN_URL . 'assets/elementor/elementor-custom-editor.css');
        }

        public function register_frontend_styles() {

            foreach( glob( BOKA_PLUG_DIR. 'assets/css/*.css' ) as $file ) {
                $filename = substr($file, strrpos($file, '/') + 1);
                wp_enqueue_style( $filename, Boka_PLUGIN_URL . 'assets/css/'.$filename);
                wp_enqueue_style( 'boka-icon', Boka_PLUGIN_URL . 'assets/css/boka/icons/flaticon.css');
            }
        }
        public function add_elementor_category() {
            \Elementor\Plugin::instance()->elements_manager->add_category(
                'boka',
                array(
                    'title' => __('Boka Addons', 'boka'),
                    'icon' => 'fa fa-plug',
                ),
                1);
        }
        
        public function include_widgets($widgets_manager) {
            $widgets[] = '';
            foreach( glob( BOKA_PLUG_DIR. 'includes/elementor-addons/*' ) as $file ) {

                $widgets[] = substr($file, strrpos($file, '/') + 1);
            }

            if (is_array($widgets)){
                $widgets = array_filter($widgets);
                foreach ($widgets as $key => $value){
                    if (!empty($value)) {
                        require_once Boka_ADDONS_DIR . ''.$value.'/index.php';
                    }
                    
                }

            }
                                                                    
        }

    }

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Boka_Elementor_Addons
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $ae = Boka(); ?>
 */
function Boka() {
    return Boka_Elementor_Addons::instance();
}

// Get Boka Running
Boka();





