<?php
/*
Plugin Name: Keybase DL tag
Plugin URI: https://github.com/Dabsunter/yourls-keybase-dl
Description: Convert public Keybase Universal Path to *.keybase.pub urls with dl=1
Version: 1.1
Author: David N. <dabsunter@gmail.com>
Author URI: https://dabsunter.fr
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

function dabs_keybase_protocol( $allowed_protocols ) {
    $allowed_protocols[] = 'keybase://';
    return $allowed_protocols;
}

function dabs_keybase_win_protocol( $allowed_protocols ) {
    $allowed_protocols[] = 'file:///'; // unsafe but temporary
    return $allowed_protocols;
}

function dabs_keybase_dl( $url, $original_url, $context ) {
    global $yourls_allowedprotocols;

    $pattern = '/(?:\/?keybase(?::\/)?|file:\/\/\/K:)\/public\/([\w-]+)\/(.*)/';
    $replacement = 'https://$1.keybase.pub/$2?dl=1';
    $new_url = preg_replace( $pattern, $replacement, $url );

    if ( !yourls_is_allowed_protocol( $new_url, $yourls_allowedprotocols ) )
            return '';
    
    return $new_url;
}

yourls_add_filter( 'kses_allowed_protocols', 'dabs_keybase_protocol' );
yourls_add_filter( 'esc_url_protocols', 'dabs_keybase_win_protocol' );
yourls_add_filter( 'esc_url', 'dabs_keybase_dl' );
