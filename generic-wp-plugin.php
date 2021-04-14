<?php

/**
 * 
 */
/*
Plugin Name: Generic WP Plugin nr 1
Plugin URI: https://generic-wp-plugin.com/
Description: Generic WP Plugin will make your blog the best blog in the world.
Version: 1.0.0
Author: Bianco Liander
Author URI: https://generic-wp-plugin.io/help/
License: GPLv2 or later
Text Domain: generic-wp-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Bosse.
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define('GWP__VERSION', '1.0.0');
define('GWP__PLUGIN_DIR', plugin_dir_path(__FILE__));


require_once(GWP__PLUGIN_DIR . 'class.generic-wp-plugin-widget.php');
require_once(GWP__PLUGIN_DIR . 'class.generic-wp-plugin-widget-backend.php');

add_action('init', array('GWP_Widget_Backend', 'init'));


if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
	require_once(GWP__PLUGIN_DIR . 'class.generic-wp-plugin-admin.php');
	add_action('init', array('GWP_Admin', 'init'));
}
