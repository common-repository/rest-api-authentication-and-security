<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_Plugin_Data_Handler {


	private static $instance;

	public static function rfapi_get_instance() {
		if ( ! isset( self::$instance ) ) {
			$class          = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	public function rfapi_handle_form_submit() {
		if ( isset( $_POST['source'] ) ) {
			$source = sanitize_text_field( wp_unslash( $_POST['source'] ) );
			check_admin_referer( $source );

			switch ( $source ) {
				case 'rfapi_protected_apis':
					if ( isset( $_POST['protected_apis'] ) ) {
						// Using custom sanitization here as we need the special characters in the rest api regex's.
						$sanitized_protected_apis = array_map( array( self::$instance, 'rfapi_custom_sanitize_api_path'), wp_unslash( $_POST['protected_apis'] ) );
						$this->rfapi_save_protected_apis( $sanitized_protected_apis );
					} else {
							$this->rfapi_save_protected_apis( array() );
					}
					break;
				case 'rfapi_master_switch':
					RFAPI_Plugin_Utils::rfapi_save_option( RFAPI_DB_Constants::MASTER_SWITCH, isset( $_POST['rfapi_master_switch'] ) );
					if ( isset( $_POST['rfapi_master_switch'] ) ) {
						RFAPI_Plugin_Utils::rfapi_set_feedback_message( 'API protection has been enabled on your site', 'success' );
					} else {
						RFAPI_Plugin_Utils::rfapi_set_feedback_message( 'API protection is now disabled on your site', 'error' );
					}
					break;
				case 'rfapi_protect_all_apis':
						$this->rfapi_protect_all_apis();
					break;
				case 'rfapi_save_authentication_method':
					if ( isset( $_POST['authentication_method'] ) && isset( $_POST['encode_method'] ) ) {
						RFAPI_Plugin_Utils::rfapi_save_option( RFAPI_DB_Constants::CONFIGURED_METHOD, sanitize_text_field( wp_unslash( $_POST['authentication_method'] ) ) );
						RFAPI_Plugin_Utils::rfapi_save_option( RFAPI_DB_Constants::ENCODING_TYPE, sanitize_text_field( wp_unslash( $_POST['encode_method'] ) ) );
						RFAPI_Plugin_Utils::rfapi_set_feedback_message( 'Authentication Settings Saved Successfully', 'success' );
					} else {
						RFAPI_Plugin_Utils::rfapi_set_feedback_message( 'Something went wrong please try again.', 'error' );
                    }
					break;
			}
		}
	}

	private function rfapi_save_protected_apis( $protected_apis ) {
		RFAPI_Plugin_Utils::rfapi_save_option( RFAPI_DB_Constants::PROTECTED_APIS, array_values( $protected_apis ) );
		RFAPI_Plugin_Utils::rfapi_set_feedback_message( 'Protected APIs Saved Successfully', 'success' );
	}

	private function rfapi_protect_all_apis() {
		$wp_rest_server_object = rest_get_server();
		$wp_rest_routes        = array_keys( $wp_rest_server_object->get_routes() );
		RFAPI_Plugin_Utils::rfapi_save_option( RFAPI_DB_Constants::PROTECTED_APIS, $wp_rest_routes );
		RFAPI_Plugin_Utils::rfapi_set_feedback_message( 'All APIs on your site are now protected Successfully', 'success' );
	}

	private function rfapi_custom_sanitize_api_path( $api_path ) {
		// Remove any potential unwanted characters, but keep valid URL and regex characters
		return preg_replace( '/[^a-zA-Z0-9\/_\-\.{}()?\[\]\+\*\|^%<>=\\\\:"\'\\\']+/', '', $api_path );
	}
	
}
