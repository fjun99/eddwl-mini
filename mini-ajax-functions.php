<?php
/**
 * Created by PhpStorm.
 * User: fangjun
 * Date: 15/4/16
 * Time: 下午4:50
 */


add_action( 'wp_ajax_my_action', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action_callback' );
function my_action_callback() {
	global $wpdb;
	$whatever = intval( $_POST['whatever'] );
	$whatever += 10;
	echo $whatever;
	wp_die();
}

