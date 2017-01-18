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
