<?php

/*
Plugin Name: EDD WL mini
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: fangjun
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'EDD_WL_MINI_VERSION' ) )
	define( 'EDD_WL_MINI_VERSION', '1.1' );


// register scripts
wp_register_script( 'edd-wl-mini', plugins_url( 'js/edd-wl-mini.js', __FILE__ ), array( 'jquery' ), EDD_WL_MINI_VERSION, true );

require_once( dirname( $this->file ) . 'mini-ajax-functions.php' );
require_once( dirname( $this->file ) . 'mini-shortcodes.php' );
