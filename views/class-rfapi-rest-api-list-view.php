<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_Rest_API_List_View {

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
		$this->rfapi_display_tab_info_section();
		$this->rfapi_display_rest_api_list();
	}

	private function rfapi_display_tab_info_section() {
		?>
			<div>
				<h1>Protected Rest APIs.</h1>
		<?php $this->rfapi_display_master_switch(); ?>
				<p>Following is the list of protected apis on your site, please select checkbox next to an API to protect it and its child APIs</p>
			</div>
		<?php
	}

	private function rfapi_display_master_switch() {
		$master_switch = RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::MASTER_SWITCH, false );
		?>
			<div class="rfapi-info-panel">
				<form method="post" id="rfapi_master_switch_form">
					<input type="text" name="source" value="rfapi_master_switch" hidden/>
		<?php wp_nonce_field( 'rfapi_master_switch' ); ?>
					
					<div style="font-size: 17px;">
						<b>Master Switch:</b>
						<label class="rfapi-switch"> 
							<input 
								type="checkbox" 
								name="rfapi_master_switch" 
								<?php echo ( $master_switch ? 'checked' : '' ); ?>
								onchange="document.getElementById('rfapi_master_switch_form').submit();"
							/>
							<span class="rfapi-slider rfapi-round"></span>
						</label> <br/>
						API Protection is currently <b><u><?php echo ( $master_switch ? 'Enabled' : 'Disabled' ); ?></u></b> on your site.
					</div>
				</form>
			</div>
		<?php
	}

	private function rfapi_display_rest_api_list() {
		$wp_rest_server_object = rest_get_server();
		$wp_rest_routes        = array_keys( $wp_rest_server_object->get_routes() );
		$wp_rest_namespaces    = $wp_rest_server_object->get_namespaces();
		$parent_namespace      = null;
		$count                 = 0;
		$protected_apis        = RFAPI_Plugin_Utils::rfapi_get_option( RFAPI_DB_Constants::PROTECTED_APIS, array() );
		?>

			<form method="post" id="rfapi_protect_all_apis_form">
				<input type="text" name="source" value="rfapi_protect_all_apis" hidden/>
				<?php wp_nonce_field( 'rfapi_protect_all_apis' ); ?>
			</form>
			
			<form method="post" >
				<input type="submit" class="button button-primary rfapi-mb-1" value="Protect Selected APIs"/>
				<input type="button" class="button button-primary rfapi-mb-1" value="Protect All APIs on My site" onclick="document.getElementById('rfapi_protect_all_apis_form').submit()"/>
				<input type="text" name="source" value="rfapi_protected_apis" hidden/>
				<div class="rfapi-api-list-div">
		<?php
		wp_nonce_field( 'rfapi_protected_apis' );

		foreach ( $wp_rest_routes as $route ) {
			$is_protected = in_array( $route, $protected_apis, true );

			if ( '/' === $route || in_array( substr( $route, 1 ), $wp_rest_namespaces, true ) ) {
				echo "
						<h3>
							<input 
								name='protected_apis[]' 
								id='parent_namespace_" . esc_attr( $count ) . "' 
								type='checkbox' 
								value='" . esc_attr( $route ) . "' 
								onClick='rfapi_check_all_sub_routes(\"" . esc_attr( $route ) . '","' . esc_attr( $count ) . "\")' 
								" . ( $is_protected ? 'checked' : '' ) . '
							/>
							' . esc_attr( $route ) . '
						</h3>
						';
				$parent_namespace = $route;
				++$count;
			} else {
				echo "
						<div class='rfapi-rest-child-path'>
							<input 
								name='protected_apis[]' 
								type='checkbox' 
								value='" . esc_attr( $route ) . "' 
								data-parent-namespace='" . esc_attr( $parent_namespace ) . "' 
								" . ( $is_protected ? 'checked' : '' ) . '
							/>
							' . esc_html( $route ) . '
						</div>
						';
			}
		}
		?>
				</div>
				<input type="submit" class="button button-primary rfapi-mt-1" value="Protect Selected APIs"/>
			</form>
		<?php
	}
}
