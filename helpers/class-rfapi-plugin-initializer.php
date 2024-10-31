<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_Plugin_Initializer {

	private static $instance;

	public static function rfapi_get_instance() {
		if ( ! isset( self::$instance ) ) {
			$class          = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	public function rfapi_include_plugin_files() {
		foreach ( glob( RFAPI_Plugin_Utils::rfapi_get_plugin_dir_path() . 'views' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
		foreach ( glob( RFAPI_Plugin_Utils::rfapi_get_plugin_dir_path() . 'helpers' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
		foreach ( glob( RFAPI_Plugin_Utils::rfapi_get_plugin_dir_path() . 'helpers' . DIRECTORY_SEPARATOR . 'constants' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
		foreach ( glob( RFAPI_Plugin_Utils::rfapi_get_plugin_dir_path() . 'handlers' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
	}

	public function rfapi_load_plugin_hooks() {
		add_action( 'admin_menu', array( $this, 'rfapi_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'rfapi_enqueue_styles' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'rfapi_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_init', array( RFAPI_Plugin_Data_Handler::rfapi_get_instance(), 'rfapi_handle_form_submit' ) );
		add_action( 'rest_api_init', array( RFAPI_REST_API_Protection_Handler::rfapi_get_instance(), 'rfapi_protect_rest_api' ) );
	}

	public function rfapi_menu() {
		add_menu_page(
			'Rest API Authentication',
			'Rest API Authentication',
			'manage_options',
			'rfapi_settings',
			array( RFAPI_View::rfapi_get_instance(), 'rfapi_render_view' ),
			RFAPI_Plugin_Utils::rfapi_get_plugin_dir_url() . 'assets/img/logo.jpeg'
		);
	}

	public function rfapi_enqueue_styles( $page ) {
		if ( 'toplevel_page_rfapi_settings' !== $page ) {
			return;
		}
		wp_enqueue_style( 'rfapi_style', plugins_url( 'assets/css/rfapi_plugin_styles.css', __DIR__ ), array(), RFAPI_Plugin_Constants::VERSION, 'all' );
	}

	public function rfapi_enqueue_scripts( $page ) {
		if ( 'toplevel_page_rfapi_settings' !== $page ) {
			return;
		}
		wp_enqueue_script( 'jQuery' );
		wp_enqueue_script( 'rfapi_plugin_scripts', plugins_url( 'assets/js/rfapi_plugin_scripts.js', __DIR__ ), array(), RFAPI_Plugin_Constants::VERSION, true );
	}
}
