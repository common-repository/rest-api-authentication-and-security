<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_Auth_Method_Configuration_View {

	private static $instance;

	/**
	 * Undocumented function
	 *
	 * @return no
	 */
	public static function rfapi_get_instance() {
		if ( ! isset( self::$instance ) ) {
			$class          = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	public function rfapi_render_view() {

		$tab_section = '';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading from URL parameter, nonce verification not required.
		if ( isset( $_GET['section'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading from URL parameter, nonce verification not required.
			$tab_section = sanitize_text_field( wp_unslash( $_GET['section'] ) );
		}
		switch ( $tab_section ) {
			case 'rfapi_configure_method':
				$method = 'basic_authentication';
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading from URL parameter, nonce verification not required.
				if ( isset( $_GET['method'] ) ) {
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading from URL parameter, nonce verification not required.
					$method = sanitize_text_field( wp_unslash( $_GET['method'] ) );
				}
				$this->rfapi_display_authentication_method_configuration( $method );
				break;
			default:
				$this->rfapi_display_tab_info_section();
				$this->rfapi_display_authentication_methods();
				break;
		}
	}

	private function rfapi_display_tab_info_section() {
		?>
		<div>
			<h1>Configure Your Rest API Protection Method</h1>
			<p>Following is the list of available API protection methods for your site, please select one to protect your APIs
				with</p>
			<p>Note: We are working on adding more API authentication methods, if you don't see your preferred method listed
				below please write a mail at <a
					href="mailto::<?php echo esc_attr( RFAPI_Plugin_Constants::CONTACT_EMAIL ); ?>"><?php echo esc_html( RFAPI_Plugin_Constants::CONTACT_EMAIL ); ?></a>
			</p>
		</div>
		<hr />
		<?php
	}

	private function rfapi_display_authentication_methods() {
		$configured_rest_api_method = RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::CONFIGURED_METHOD, false );

		if ( true !== $configured_rest_api_method ) {
			echo '<h3>Current Configured Method is: Basic Authentication</h3>';
		}
		$redirect_url = '#';
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$redirect_url = esc_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) . '&section=rfapi_configure_method&method=' . RFAPI_Plugin_Constants::AUTH_METHOD_BASIC_AUTHENTICATION;
		}
		?>
		<div>
			<div class="rfapi-auth-method-card 
		<?php echo ( RFAPI_Plugin_Constants::AUTH_METHOD_BASIC_AUTHENTICATION === $configured_rest_api_method ) ? 'rfapi-auth-method-card-selected' : ''; ?>"
				onclick="rfapi_redirect_to_url('<?php echo esc_url( $redirect_url ); ?>')"
			>
				<div>
					<img class="rfapi-card-icon"
						src="<?php echo esc_url( RFAPI_Plugin_Utils::rfapi_get_plugin_dir_url() ); ?>/assets/img/basic_authentication.svg" />
				</div>
				<div>
					<div><b>Basic Authentication</b></div>
					<div>Authenticate with user credentials</div>
				</div>
			</div>
		</div>
		<?php
	}

	private function rfapi_display_authentication_method_configuration( $method ) {
		$encoding_method = RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::ENCODING_TYPE );
		echo '<h1>Configure ' . esc_html( RFAPI_Plugin_Constants::AUTH_METHOD_DISPLAY_NAME[ $method ] ) . ' Settings.</h1>';
		echo wp_kses( RFAPI_Plugin_Constants::AUTH_METHOD_DESC[ $method ], RFAPI_Plugin_Constants::ALLOWED_HTML );
		?>
			<div>
				<label>Select method: </label>
				<form method="post">
					<input type="text" name="source" value="rfapi_save_authentication_method" hidden/>
					<input type="text" name="authentication_method" value="<?php echo esc_attr( $method ); ?>" hidden/>
					<?php wp_nonce_field( 'rfapi_save_authentication_method' ); ?>
					<select name='encode_method' id='encode_method' onchange="rfapi_select_encode_method()">
						<option value='base64_encoded' <?php echo ( 'base64_encode' === $encoding_method ) ? 'selected' : ''; ?> >Base 64 Encoded Credentials [Recommended]</option>
						<option value='plain_text' <?php echo ( 'plain_text' === $encoding_method ) ? 'selected' : ''; ?>>Plain text Credentials</option>
					</select>
					<input type="submit" class="button button-primary rfapi-mb-1" value="Save"/>
				</form>
			</div>
			<div>
				<h3>Example:</h3>
				<div class="rfapi-example" id="base64_encoded">
					<div class="rfapi-dflex">Username :&nbsp; <div class="rfapi-example-value">testuser </div></div><br>
					<div class="rfapi-dflex">Password :&nbsp; <div class="rfapi-example-value">password </div></div><br>
					<div class="rfapi-dflex">EncodedValue:&nbsp; <div class="rfapi-example-value"><?php echo esc_html( base64_encode( 'testuser:password' ) ); ?> <i>[base64 encode of "testuser:password"]</i></div></div><br>
					<div class="rfapi-dflex">Request Header:&nbsp; Authorization Basic &nbsp;<div class="rfapi-example-value"><?php echo esc_html( base64_encode( 'testuser:password' ) ); ?> </div></div>
				</div>
				<div class="rfapi-example" id="plain_text">
					<div class="rfapi-dflex">Username :&nbsp; <div class="rfapi-example-value">testuser </div></div><br>
					<div class="rfapi-dflex">Password :&nbsp; <div class="rfapi-example-value">password </div></div><br>
					<div class="rfapi-dflex">EncodedValue:&nbsp; <div class="rfapi-example-value">testuser:password <i>[Concatenation of the username and password keeping : as separator.]</i></div></div><br>
					<div class="rfapi-dflex">Request Header :&nbsp; <div class="rfapi-example-value">Authorization Basic testuser:password </div></div>
				</div>
			</div>
		<?php
	}
}
