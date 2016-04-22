<?php

defined( 'ABSPATH' ) or die( 'Nice try!' );

require( plugin_dir_path( __FILE__ ) . 'class-simple-settings-page.php' );

if ( ! class_exists(Firefly_Fields_Plugin) ):

class Firefly_Fields_Plugin {

    /**
     * Provide static variable to enforce singleton pattern
     * 
     * @var Object Instance of this class
     *
     * @since   0.0.3
     */
    private static $instance;

    public static function get_instance() {
        if( null == self::$instance ) {
            self::$instance = new self; // i.e., new Firefly_Fields_Plugin()
        }
        return self::$instance;
    }

    public function __construct() {

        // Implement first feature
        add_action( 'init', array( $this, 'implement_feature_1' ) );
    }

    /**
     * Implement feature 1 of the plugin, i.e., enable toggling of widget shortcodes
     *
     * @var   Array Contents of 'add_widget_shortcodes' option
     *
     * @uses   get_option
     *
     * @since  0.1.0 
     */
    public function implement_feature_1() {
        // implement feature Add Shortcode to Widgets
        $add_widget_shortcodes = get_option('add_widget_shortcodes');
        if ( ! empty($add_widget_shortcodes) && $add_widget_shortcodes[0] == "option1" ) {
            add_action('widget_text', 'do_shortcode');
        }
    }

}

endif;