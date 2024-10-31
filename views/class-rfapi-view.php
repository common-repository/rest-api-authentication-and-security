<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_View {

	private static $instance;

	public static function rfapi_get_instance() {
		if ( ! isset( self::$instance ) ) {
			$class          = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	public function rfapi_render_view() {
		$current_tab = RFAPI_Plugin_Constants::TAB_PROTECTED_APIS;

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading from URL parameter, nonce verification not required.
		if ( isset( $_GET['tab'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading from URL parameter, nonce verification not required.
			$current_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		}

		?>
			<div class="rfapi-ui-container">
		<?php
		$this->rfapi_header();
		RFAPI_Plugin_Utils::rfapi_display_feedback_notice();
		$this->rfapi_display_nav( $current_tab );
		?>
			<div class="rfapi-tab-content-div">
			<?php
				$this->rfapi_render_tab( $current_tab );
			?>
			</div>
			</div>
		<?php
	}

	private function rfapi_render_tab( $current_tab ) {

		switch ( $current_tab ) {
			case RFAPI_Plugin_Constants::TAB_AUTH_METHOD:
				$view = RFAPI_Auth_Method_Configuration_View::rfapi_get_instance();
				$view->rfapi_render_view();
				break;
			case RFAPI_Plugin_Constants::TAB_PROTECTED_APIS:
				$view = RFAPI_Rest_API_List_View::rfapi_get_instance();
				$view->rfapi_render_view();
				break;
		}
	}

	private function rfapi_header() {
		?>
			<div class="rfapi-header">
				<h1>Rest API Protection by Rainforest Security</h1>
			</div>
		<?php
	}

	private function rfapi_display_nav( $current_tab ) {
		$url = '';
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$url = esc_url( remove_query_arg( array( 'method', 'section' ), sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) );
		}
		?>
			<div class="rfapi-tabs">
				<a 
					class="rfapi-nav-tab <?php echo esc_html( RFAPI_Plugin_Constants::TAB_PROTECTED_APIS === $current_tab ? 'rfapi-nav-tab-active' : '' ); ?>" 
					href="<?php echo esc_url( add_query_arg( array( 'tab' => RFAPI_Plugin_Constants::TAB_PROTECTED_APIS ), $url ) ); ?>
				">
					Protected Apis
				</a>
				<a 
					class="rfapi-nav-tab <?php echo esc_html( RFAPI_Plugin_Constants::TAB_AUTH_METHOD === $current_tab ? 'rfapi-nav-tab-active' : '' ); ?>" 
					href="<?php echo esc_url( add_query_arg( array( 'tab' => RFAPI_Plugin_Constants::TAB_AUTH_METHOD ), $url ) ); ?>
				">
					Authentication Methods
				</a>
			</div>
		<?php
	}
}
