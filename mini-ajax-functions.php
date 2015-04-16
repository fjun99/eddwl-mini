<?php
/**
 * Created by PhpStorm.
 * User: fangjun
 * Date: 15/4/16
 * Time: 下午4:50
 */


/*
 * test "my_action"
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


/**
 *
 * edd_add_to_wish_list_mini
 *
 * Adds item to the selected wish list(default), or creates a new list, via AJAX. Based off edd_ajax_add_to_cart()
 *
 * @since 1.0
 * @return void
 */
function edd_ajax_add_to_wish_list_mini() {

	if ( isset( $_POST['download_id'] ) ) {
		global $post;

		$to_add = array();

		if ( isset( $_POST['price_ids'] ) && is_array( $_POST['price_ids'] ) ) {
			foreach ( $_POST['price_ids'] as $price ) {
				$to_add[] = array( 'price_id' => $price );
			}
		}

		// create a new list
		$create_list = isset( $_POST['new_or_existing'] ) && 'new-list' == $_POST['new_or_existing'] ? true : false;

		// the new list name being created. Fallback for blank list names
		$list_name = isset( $_POST['list_name'] ) && ! empty( $_POST['list_name'] ) ? $_POST['list_name'] : __( 'My list', 'edd-wish-lists' );

		// the new list's status
		$list_status = isset( $_POST['list_status'] ) ? $_POST['list_status'] : '';

		$list_id = isset( $_POST['list_id'] ) ? $_POST['list_id'] : '';

		$return = array();

		// create new list
		if ( true == $create_list ) {
			$args = array(
				'post_title'    => $list_name,
				'post_content'  => '',
				'post_status'   => $list_status,
				'post_type'     => 'edd_wish_list',
			);

			$list_id = wp_insert_post( $args );

			if ( $list_id ) {
				$return['list_created'] = true;
				$return['list_name'] = $list_name;
			}
		}

		// add each download to wish list
		foreach ( $to_add as $options ) {
			if ( $_POST['download_id'] == $options['price_id'] ) {
				$options = array();
			}

			edd_wl_add_to_wish_list( $_POST['download_id'], $options, $list_id );
		}

		// get title of list
		$title = get_the_title( $list_id );
		// get URL of list
		$url = get_permalink( $list_id );

		$return['success'] = sprintf( __( 'Successfully added to <strong>%s</strong>', 'edd-wish-lists' ), '<a href="' . $url . '">' . $title . '</a>' );

		echo json_encode( $return );
	}
	edd_die();
}
add_action( 'wp_ajax_edd_add_to_wish_list_mini', 'edd_ajax_add_to_wish_list_mini' );
add_action( 'wp_ajax_nopriv_edd_add_to_wish_list_mini', 'edd_ajax_add_to_wish_list_mini' );

