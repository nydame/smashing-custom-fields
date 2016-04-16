<?php
/*
	Plugin Name: Firefly Demo Plugin
	Version: 1.0.0
*/

/**
 * FIREFLY PLUGIN
 *
 * @package   FIREFLY PLUGIN
 * @author    Felicia Betancourt <bosslady@go-firefly.com>
 * @license   GPL-2.0+
 * @link      https://github.com/nydame/smashing-custom-fields/tree/nydames-work
 * @copyright 2013 Felicia Betancourt
 *
 * @wordpress-plugin
 * Plugin Name: Firefly Demo Plugin
 * Description: Based on Matthew Ray's Smashing Magazine tutorial on Setting up custom fields for a plugin (https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/). I also use some things I learned from a Tom McFarlin tutorial. 
 * 
 * --Things that have changed in version 0.0.2: Code was refactored so that class definition was placed in its own file.
 *
 * --Things that have changed in version 0.0.3: Singleton pattern has been enforced.
 *
 * --New in version 0.1.0: Fields displayed on plugin's settings page have been narrowed down to those needed for feature set that is being developed. As those features are implemented, version number will be 0.1.x. Also, some documentation of class properties and methods has begun.
 *
 * 
 * Author: Felicia Betancourt
 * Author URI:  http://go-firefly.com/
 * Plugin URI:  
 * Version:     0.1.0
 * Text Domain: firefly-plugin
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */    

defined( 'ABSPATH' ) or die( 'Nice try!' );

require_once( plugin_dir_path( __FILE__ ) . 'class-firefly-plugin.php' );

// new Firefly_Fields_Plugin();
Firefly_Fields_Plugin::get_instance();
