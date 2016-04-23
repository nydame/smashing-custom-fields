<?php
/*
	Plugin Name: Firefly Demo Plugin
	Version: 1.0.0
*/

/**
 * FIREFLY DEMO PLUGIN
 *
 * @package   FIREFLY DEMO PLUGIN
 * @author    Felicia Betancourt <info@go-firefly.com>
 * @license   GPL-2.0+
 * @link      https://github.com/nydame/smashing-custom-fields/tree/nydames-work
 * @copyright 2013 Felicia Betancourt
 *
 * @wordpress-plugin
 * Plugin Name: Firefly Demo Plugin
 * Description: Chiefly based on Matthew Ray's Smashing Magazine tutorial on setting up custom fields for a plugin (https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/). I also weave in some of the many things I learned from Tom McFarlin's tutorial (https://tommcfarlin.com/how-to-build-a-wordpress-plugin/) and from the WordPress Plugin Boilerplate project (http://wppb.io/) which he started.
 *
 * 
 * Author: Felicia Betancourt
 * Author URI:  http://go-firefly.com/
 * Plugin URI:  
 * Version:     0.1.0
 * Text Domain: firefly-demo-plugin
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */  

/*
Copyright 2016  Felicia Betancourt  (email : info@go-firefly.com)

This program is free software designed chiefly for teaching purposes; 
you can redistribute it and/or modifyit under the terms of the 
GNU General Public License, version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

For a copy of the GNU General Public License, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

See readme.txt for changelog.
*/  

defined( 'ABSPATH' ) or die( 'Nice try!' );

// SET VERSION NUMBER
define( 'FIREFLY_DEMO_VERSION','0.1.1' );

// SET TEXT-DOMAIN
define('FIREFLY_DEMO_SLUG', 'firefly_demo');

// CREATE SETTINGS PAGE

require_once( plugin_dir_path( __FILE__ ) . 'class-simple-settings-page.php' );

// new Simple_Settings_Page object, or use pre-existing one
Simple_Settings_Page::get_instance( FIREFLY_DEMO_VERSION, FIREFLY_DEMO_SLUG );

// IMPLEMENT SETTINGS

require_once( plugin_dir_path( __FILE__ ) . 'class-firefly-demo-plugin.php' );

// new Firefly_Demo_Plugin object, or use pre-existing one
Firefly_Demo_Plugin::get_instance();

