<?php
/**
 * Plugin Name:       REST API Authentication and Security
 * Plugin URI:        rest-api-authentication-and-security
 * Description:       Make your WordPress REST APIs secure with various authentication methods.
 * Version:           1.0.0
 * Author:            Rainforest Security
 * Author URI:        https://rainforestsecurity.com
 * License:           GPLv2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'helpers' . DIRECTORY_SEPARATOR . 'class-rfapi-plugin-utils.php';
require_once 'helpers' . DIRECTORY_SEPARATOR . 'class-rfapi-plugin-initializer.php';

class RFRC_Rest_Api_Authentication {


	private static $instance;

	public static function rfapi_get_instance() {
		if ( ! isset( self::$instance ) ) {
			$class          = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	public function __construct() {
		$rfapi_plugin_initializer = RFAPI_Plugin_Initializer::rfapi_get_instance();
		$rfapi_plugin_initializer->rfapi_include_plugin_files();
		$rfapi_plugin_initializer->rfapi_load_plugin_hooks();
	}
}

RFRC_Rest_Api_Authentication::rfapi_get_instance();
