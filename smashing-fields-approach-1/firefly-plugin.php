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
 * Plugin Name: FIREFLY PLUGIN
 * Description: Based on Matthew Ray's Smashing Magazine tutorial on Setting up custom fields for a plugin (https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/). I also use some things I learned from a Tom McFarlin tutorial. Things that have changed since version 0.0.1: Code was refactored so that class definition was placed in its own file.
 * Author: Felicia Betancourt
 * Author URI:  http://go-firefly.com/
 * Plugin URI:  
 * Version:     0.2.0
 * Text Domain: firefly-plugin
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */    

require_once( plugin_dir_path( __FILE__ ) . 'class-firefly-plugin.php' );

new Firefly_Fields_Plugin();
