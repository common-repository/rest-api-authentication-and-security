<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_REST_API_Protection_Handler {


	private static $instance;

	public static function rfapi_get_instance() {
		if ( ! isset( self::$instance ) ) {
			$class          = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	public function rfapi_protect_rest_api() {
		if ( ( isset( $_SERVER['REQUEST_METHOD'] ) && 'OPTIONS' === $_SERVER['REQUEST_METHOD'] )
			|| ! RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::MASTER_SWITCH, false )
			|| is_user_logged_in()
			|| ! $this->rfapi_is_protected_api()
		) {
			return;
		}
		$headers = $this->rfapi_get_all_request_headers();

		$configured_authentication_method = RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::CONFIGURED_METHOD, '' );
		switch ( $configured_authentication_method ) {
			case RFAPI_Plugin_Constants::AUTH_METHOD_BASIC_AUTHENTICATION:
				if ( $this->rfapi_check_basic_authentication( $headers ) ) {
					return;
				}
				break;
		}
		wp_send_json(
			array(
				'status'            => 'error',
				'error'             => 'UNAUTHORIZED',
				'code'              => '401',
				'error_description' => 'You do not have permission to access this API.',
			),
			401
		);
	}

	private function rfapi_check_basic_authentication( $headers ) {
		if ( isset( $headers['Authorization'] ) && '' !== $headers['Authorization'] ) {
			$auth_token = explode( ' ', $headers['Authorization'] );
			if ( isset( $auth_token[1] ) ) {
				$auth_token                 = $auth_token[1];
				$configured_encoding_method = RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::ENCODING_TYPE, 'base64_encoded' );
				if ( 'base64_encoded' === $configured_encoding_method ) {
					// Using base decode to decode the encoded token value.
					$auth_token = base64_decode( $auth_token );
				}
				$auth_token = explode( ':', $auth_token );
				if ( wp_authenticate_username_password( null, $auth_token[0], $auth_token[1] ) instanceof WP_User ) {
					return true;
				} else {
					wp_send_json(
						array(
							'status'            => 'error',
							'error'             => 'BAD REQUEST',
							'code'              => '400',
							'error_description' => 'Invalid username or password.',
						),
						400
					);
				}
			}
		}
		return false;
	}

	private function rfapi_is_protected_api() {
		global $wp;
		if ( isset( $wp->query_vars['rest_route'] ) ) {
			$current_route    = $wp->query_vars['rest_route'];
			$protected_routes = RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::PROTECTED_APIS, array() );
			return in_array( $current_route, $protected_routes, true );
		}
		return false;
	}

	/**
	 * Extracts all the headers that start with HTTP_ and converts them into a more human readable format
	 *
	 * @return array
	 */
	private function rfapi_get_all_request_headers() {
		$headers = array();
		foreach ( $_SERVER as $key => $value ) {
			if ( substr( $key, 0, 5 ) !== 'HTTP_' ) {
				continue;
			}
			$header             = str_replace( ' ', '-', ucwords( str_replace( '_', ' ', strtolower( substr( $key, 5 ) ) ) ) );
			$headers[ $header ] = $value;
		}
		return $headers;
	}
}
