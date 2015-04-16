<?php
/**
 * Created by PhpStorm.
 * User: fangjun
 * Date: 15/4/16
 * Time: 下午4:50
 */


/**
 * Add to wish list shortcode
 *
 * @param  array $atts
 * @param  $content
 * @return object
 * @since  1.0
 */
function edd_wl_add_to_list_mini_shortcode( $atts, $content = null ) {
	global $post, $edd_options;
/*
	extract( shortcode_atts( array(
			'id' 		=> $post->ID,
			'text' 		=> ! empty( $edd_options[ 'edd_wl_add_to_wish_list' ] ) ? $edd_options[ 'edd_wl_add_to_wish_list' ] : __( 'Add to wish list', 'edd-wish-lists' ),
			'icon'		=> $edd_options[ 'edd_wl_icon' ] ? $edd_options[ 'edd_wl_icon' ] : 'star',
			'option'	=> 1, 		// default variable pricing option
			'style'		=> $edd_options[ 'edd_wl_button_style' ] ? $edd_options[ 'edd_wl_button_style' ] : 'button',
		), $atts, 'edd_wish_lists_add' )
	);

	$args = apply_filters( 'edd_wl_add_to_list_shortcode', array(
		'download_id' 	=> $id,
		'text' 			=> $text,
		'icon'			=> $icon,
		'style'			=> $style,
		'action'		=> 'edd_wl_open_modal',
		'class'			=> 'edd-wl-open-modal edd-wl-action before',
		'price_option'	=> $option,
		'shortcode'		=> true // used to return the links, not echo them in edd_wl_wish_list_link()
	), $id, $option );

	$content = edd_wl_wish_list_link( $args );
*/
	// load required scripts for this shortcode
	wp_enqueue_script( 'edd-wl-mini' );

	$content = "<p class='btn'>EDD WL MINI</p>";
	return $content;
}
add_shortcode( 'edd_wish_lists_add_mini', 'edd_wl_add_to_list_mini_shortcode' );