<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

require_once __DIR__ . '/helpers/class-rfapi-plugin-utils.php';
require_once __DIR__ . '/helpers/constants/class-rfapi-db-constants.php';

RFAPI_Plugin_Utils::rfapi_delete_option( RFAPI_DB_Constants::CONFIGURED_METHOD );
RFAPI_Plugin_Utils::rfapi_delete_option( RFAPI_DB_Constants::ENCODING_TYPE );
RFAPI_Plugin_Utils::rfapi_delete_option( RFAPI_DB_Constants::FEEDBACK_MESSAGE );
RFAPI_Plugin_Utils::rfapi_delete_option( RFAPI_DB_Constants::FEEDBACK_MESSAGE_TYPE );
RFAPI_Plugin_Utils::rfapi_delete_option( RFAPI_DB_Constants::MASTER_SWITCH );
RFAPI_Plugin_Utils::rfapi_delete_option( RFAPI_DB_Constants::PROTECTED_APIS );
