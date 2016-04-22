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
 * 
 * Author: Felicia Betancourt
 * Author URI:  http://go-firefly.com/
 * Plugin URI:  
 * Version:     0.1.0
 * Text Domain: firefly-plugin
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */  

/*
Copyright 2016  Felicia Betancourt  (email : info@go-firefly.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

For a copy of the GNU General Public License, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

See readme.txt for changelog.
*/  

defined( 'ABSPATH' ) or die( 'Nice try!' );

require_once( plugin_dir_path( __FILE__ ) . 'class-firefly-plugin.php' );

// new Firefly_Fields_Plugin object, or use pre-existing one
Firefly_Fields_Plugin::get_instance();

