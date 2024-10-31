<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RFAPI_Plugin_Constants {

	const VERSION = '1.0.0';

	const TAB_AUTH_METHOD    = 'authentication_methods';
	const TAB_PROTECTED_APIS = 'protected_apis';

	const CONTACT_EMAIL = 'support@rainforestsecurity.com';

	const AUTH_METHOD_BASIC_AUTHENTICATION = 'basic_authentication';

	const AUTH_METHOD_DESC = array(
		'basic_authentication' => '<p>In this method you pass the WordPress username and password as the Basic Authentication header. <br>You can optionally enable encoding them using based 64.</p>',
	);

	const AUTH_METHOD_DISPLAY_NAME = array(
		'basic_authentication' => 'Basic Authentication',
	);

	const ALLOWED_HTML = array(
		'p'  => array(),
		'br' => array(),
		'h3' => array(),
	);
}
