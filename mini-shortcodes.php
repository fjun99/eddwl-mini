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
		'action'		=> 'edd_ajax_add_to_wish_list_mini',
		'class'			=> 'edd-wl-open-modal edd-wl-action edd-wish-lists-add-mini before',
		'price_option'	=> $option,
		'shortcode'		=> true // used to return the links, not echo them in edd_wl_wish_list_link()
	), $id, $option );

/*
array(8) { ["download_id"]=> string(3) "170"
["text"]=> string(6) "收藏"
["icon"]=> string(5) "heart"
["style"]=> string(6) "button"
["action"]=> string(17) "edd_wl_open_modal"
["class"]=> string(38) "edd-wl-open-modal edd-wl-action before"
["price_option"]=> int(1)
["shortcode"]=> bool(true) }
 */

	$content = edd_wl_wish_list_link_mini( $args );

	// load required scripts for this shortcode
	wp_enqueue_script( 'edd-wl-mini' );

//	wp_enqueue_script('ajax-script');


//	$content = "<p class='btn'>EDD WL MINI</p>";
	return $content;
}
add_shortcode( 'edd_wish_lists_add_mini', 'edd_wl_add_to_list_mini_shortcode' );




/**
 * Template functions
 *
 * The Wish list link
 *
 * @since 1.0
 */
function edd_wl_wish_list_link_mini( $args = array() ) {
	global $edd_options, $post;

	$defaults = apply_filters( 'edd_wl_link_defaults',
		array(
			'download_id' 	=> isset( $post->ID ) ? $post->ID : '',
			'text'        	=> ! empty( $edd_options[ 'edd_wl_add_to_wish_list' ] ) ? $edd_options[ 'edd_wl_add_to_wish_list' ] : '',
			'style'       	=> edd_get_option( 'edd_wl_button_style', 'button' ),
			'color'       	=> '',
			'class'       	=> 'edd-wl-action',
			'icon'			=> edd_get_option( 'edd_wl_icon', 'star' ),
			'action'		=> '',
			'link'			=> '',
			'link_size'		=> '',
			'price_option'	=> '',
		)
	);

	// merge arrays
	$args = wp_parse_args( $args, $defaults );

	// extract $args so we can use the variable names
	extract( $args, EXTR_SKIP );

	// manually select price option for shortcode
	$price_opt 				= isset( $price_option ) ? ( $price_option - 1 ) : ''; // so user can enter in 1, 2,3 instead of 0, 1, 2 as option
	$price_option 			= $price_option ? ' data-price-option="' . $price_opt . '"' : '';

	if ( ! $price_option ) {
		$variable_pricing 	= edd_has_variable_prices( $args['download_id'] );
		$data_variable  	= $variable_pricing ? ' data-variable-price=yes' : 'data-variable-price=no';
		$type             	= edd_single_price_option_mode( $args['download_id'] ) ? 'data-price-mode=multi' : 'data-price-mode=single';
	}
	else {
		$data_variable = '';
		$type = '';
	}

	ob_start();

	$icon = $icon && 'none' != $icon ? '<i class="glyphicon glyphicon-' . $icon . '"></i>' : '';

	// shortcode parameter for returning function
	$shortcode = isset( $shortcode ) ? $shortcode : '';

	// size of plain text or button link
	$link_size = $link_size ? $link_size : '';

	// show the icon on either the left or right
	$icon_position = apply_filters( 'edd_wl_icon_position' , 'left' );

	// move the icon based on the location of the icon
	$icon_left = 'left' == $icon_position ? $icon : '';
	$icon_right = 'right' == $icon_position ? $icon : '';

//	//BYFJ
//	$class .= "edd-wish-lists-add-mini";

	$class .= 'right' == $icon_position ? ' glyph-right' : ' glyph-left';
	$class .= ! $text ? ' no-text' : '';


	// change CSS class based on style chosen
	if ( 'button' == $style )
		$style = 'edd-wl-button';
	elseif ( 'plain' == $style )
		$style = 'plain';

	// if link is specified, don't show spinner
	$loading = ! $link ? '<span class="edd-loading"><i class="edd-icon-spinner edd-icon-spin"></i></span>' : '';
	$link = ! $link ? '#' : $link;

	// text
	$text = $text ? '<span class="label">' . esc_attr( $text ) . '</span>' : '';

	// data action
	$action = $action ? 'data-action="' . $action . '"' : '';

	// download ID
	$download_id = $download_id ? 'data-download-id="' . esc_attr( $download_id ) . '"' : '';

	printf(
		'<a href="%1$s" class="%2$s %3$s" %4$s %5$s %6$s %7$s %12$s>%8$s%9$s%10$s%11$s</a>',
		$link, 														// 1
		implode( ' ', array( $style, $color, trim( $class ) ) ), 	// 2
		$link_size, 												// 3
		$action, 													// 4
		$download_id, 												// 5
		esc_attr( $data_variable ),									// 6
		esc_attr( $type ), 											// 7
		$icon_left, 												// 8
		$text,														// 9
		$loading, 													// 10
		$icon_right, 												// 11
		$price_option 												// 12
	);

	$html = apply_filters( 'edd_wl_link', ob_get_clean() );

	// return for shortcode, else echo
	if ( $shortcode ) {
		return $html;
	}
	else {
		echo $html;
	}
}
