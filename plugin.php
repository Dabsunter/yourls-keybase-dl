<?php
/*
Plugin Name: Keybase DL tag
Plugin URI: https://github.com/your_name/your_plugin
Description: Add dl tag to *.keybase.pub urls
Version: 1.0
Author: David N. <dabsunter@gmail.com>
Author URI: https://dabsunter.fr
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

function dabs_keybase_dl( $url ) {
    if ( preg_match( "/[a-z0-1]+\.keybase\.pub/", $url )
            && !dabs_str_end_with( $url, "?dl=1") ) {
        return $url . "?dl=1";
    } else {
        return $url;
    }
}

function dabs_str_end_with( $str, $sub ) {
    return substr_compare($str, $sub, -strlen($sub)) === 0;
}

yourls_add_filter( 'sanitize_url', 'dabs_keybase_dl' );