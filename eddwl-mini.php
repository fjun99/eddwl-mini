<?php

/*
Plugin Name: EDD WL mini
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: extension of EDD Wish Lists.
Version: 1.0
Author: fangjun
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function edd_wl_mini_print_scripts() {

	if ( ! defined( 'EDD_WL_MINI_VERSION' ) ) {
		define( 'EDD_WL_MINI_VERSION', '1.0' );
	}

	// register scripts
	wp_register_script( 'edd-wl-mini', plugins_url( '/js/edd-wl-mini.js', __FILE__ ), array( 'jquery' ), EDD_WL_MINI_VERSION, true );


	wp_enqueue_script( 'ajax-script', plugins_url( '/js/my_query.js', __FILE__ ), array('jquery'),EDD_WL_MINI_VERSION, true  );

	// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	wp_localize_script( 'ajax-script', 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
}
add_action( 'wp_enqueue_scripts', 'edd_wl_mini_print_scripts', 100 );


add_action( 'wp_ajax_my_action', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action_callback' );
function my_action_callback() {
	global $wpdb;
	$whatever = intval( $_POST['whatever'] );
	$whatever += 10;
	echo $whatever;
	wp_die();
}



require_once( dirname( __FILE__ ) . '/mini-ajax-functions.php' );
require_once( dirname( __FILE__ ) . '/mini-shortcodes.php' );
