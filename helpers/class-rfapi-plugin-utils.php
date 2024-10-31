<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_Plugin_Utils {

	public static function rfapi_get_plugin_dir_path() {
		return plugin_dir_path( __DIR__ );
	}

	public static function rfapi_get_plugin_dir_url() {
		return plugin_dir_url( __DIR__ );
	}

	public static function rfapi_get_option( $option_name, $default_return_value = false ) {
		return get_site_option( $option_name, $default_return_value );
	}

	public static function rfapi_save_option( $option_name, $value ) {
		update_site_option( $option_name, $value );
	}

	public static function rfapi_delete_option( $option_name ) {
		delete_site_option( $option_name );
	}

	public static function rfapi_set_feedback_message( $message, $type ) {
		self::rfapi_save_option( RFAPI_DB_Constants::FEEDBACK_MESSAGE, $message );
		self::rfapi_save_option( RFAPI_DB_Constants::FEEDBACK_MESSAGE_TYPE, $type );
	}

	public static function rfapi_display_feedback_notice() {
		$feedback_message = self::rfapi_get_option( RFAPI_DB_Constants::FEEDBACK_MESSAGE );
		if ( $feedback_message ) {
			$message_type       = self::rfapi_get_option( RFAPI_DB_Constants::FEEDBACK_MESSAGE_TYPE, 'success' );
			$message_class_name = 'rfapi-message-' . $message_type;
			?>
				<div class='rfapi-message <?php echo esc_attr( $message_class_name ); ?>'> 
			<?php echo esc_html( $feedback_message ); ?> 
				</div>
			<?php
			self::rfapi_delete_option( RFAPI_DB_Constants::FEEDBACK_MESSAGE );
		}
	}
}
