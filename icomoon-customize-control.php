<?php
/*
Plugin Name: IcoMoon Customize Control
Plugin URI: https://github.com/elvishp2006/icomoon-wp-customize-control/
Description: Implement a custom IcoMoon control for WP Customize
Author: Elvis Henrique <elvishp2006@gmai.com>
Version: 0.1.0
Author URI: https://github.com/elvishp2006/
*/

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

# Define root URL
if ( ! defined( 'IWCC_URL' ) ) {
	$url = trailingslashit( __DIR__ );
	$count = 0;

	# Sanitize directory separator on Windows
	$url = str_replace( '\\' ,'/', $url );

	# If installed as a plugin
	$wp_plugin_dir = str_replace( '\\' ,'/', WP_PLUGIN_DIR );
	$url = str_replace( $wp_plugin_dir, plugins_url(), $url, $count );

	if ( $count < 1 ) {
		# If anywhere in wp-content
		$wp_content_dir = str_replace( '\\' ,'/', WP_CONTENT_DIR );
		$url = str_replace( $wp_content_dir, content_url(), $url, $count );
	}

	if ( $count < 1 ) {
		# If anywhere else within the WordPress installation
		$wp_dir = str_replace( '\\' ,'/', ABSPATH );
		$url = str_replace( $wp_dir, site_url( '/' ), $url );
	}

	define( 'IWCC_URL', untrailingslashit( $url ) );
}

add_action( 'customize_register', 'iwcc_register_control' );

function iwcc_register_control( $wp_customize )
{
	require_once( dirname( __FILE__ ) . '/class-icomoon-customize-control.php' );

	$wp_customize->register_control_type( 'Icomoon_Customize_Control' );

	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['icomoon'] = 'Icomoon_Customize_Control';
		return $controls;
	} );
}
