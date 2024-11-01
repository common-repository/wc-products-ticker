<?php
/**
 * Plugin Name: WooCommerce Products Ticker
 * Plugin URI: http://www.amitythemes.com
 * Description: WooCommerce Products Ticker is a Free Widget that helps you to scroll your products bottom-to-top/top-to-bottom vertically.
 * Version: 1.1
 * Author: Amity Themes
 * Author URI: http://www.amitythemes.com
 * Requires at least: 4.1
 * Tested up to: 4.3
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languagesCopyright 2015  Amity Themes  (email : info@amitythemes.com)
 * Text Domain: wcpt-widget
 *
 * @package WooCommerce Products Ticker Widget
 * @since      1.0
 * @author AmityThemes
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* 
* Global Paths and Folders.
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/

define( 'WCPT_PLUGIN_PATH'       	,  plugin_dir_url(  __FILE__  ) );
define( 'WCPT_PLUGIN_DIR'        	,  dirname( __FILE__ ) . '/' );
define( 'WCPT_PLUGIN_MAIN_PATH'  	,  plugin_basename( __FILE__ ) );

define( 'WCPT_ADMIN_FOLDER'      	,  WCPT_PLUGIN_PATH	 		. 'admin/');
define( 'WCPT_ADMIN_CSS_FOLDER'  	,  WCPT_ADMIN_FOLDER 	 	. 'css/');
define( 'WCPT_ADMIN_ACCORDION_CSS'	,  WCPT_ADMIN_CSS_FOLDER	. 'widget.css');
define( 'WCPT_ADMIN_JS_FOLDER'   	,  WCPT_ADMIN_FOLDER	 	. 'js/');
define( 'WCPT_ACCORDION_JS'       	,  WCPT_ADMIN_JS_FOLDER 	. 'jquery.accordion.js');
define( 'WCPT_INC_FOLDER'        	,  WCPT_PLUGIN_DIR		 	. 'inc/');
define( 'WCPT_TEM_FOLDER'        	,  WCPT_PLUGIN_DIR		 	. 'templates/');
define( 'WCPT_ASSETS_FOLDER'     	,  WCPT_PLUGIN_PATH	 		. 'assets/');
define( 'WCPT_CSS_FOLDER'        	,  WCPT_ASSETS_FOLDER	 	. 'css/');
define(	'WCPT_STYLE_CSS'		 	,  WCPT_CSS_FOLDER		 	. 'wcpt-style.css');
define( 'WCPT_JS_FOLDER'         	,  WCPT_ASSETS_FOLDER	 	. 'js/');
define( 'WCPT_TICKER_JS'         	,  WCPT_JS_FOLDER		 	. 'jquery.easy-ticker.min.js');
define( 'WCPT_EASING_JS'         	,  WCPT_JS_FOLDER		 	. 'jquery.easing.min.js');
define( 'WCPT_IMG_FOLDER'        	,  WCPT_ASSETS_FOLDER	 	. 'images/');
define( 'WCPT_NO_THUMB'     	 	,  WCPT_ASSETS_FOLDER	 	. 'no-thumb.png');

/* 
* Widget.php
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/
require_once(WCPT_INC_FOLDER . 'class-wcpt-widget.php');

/* 
* Functions.php
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/
require_once(WCPT_INC_FOLDER . 'functions.php');


/* 
* Aq_resizer.php
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/
require_once(WCPT_INC_FOLDER . 'aq_resizer.php');

/* 
* All Hooks, Filters & Actions
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/

// Init widget
add_action( 'widgets_init', 'WC_Product_Ticker' );

// Load latest jQuery
add_action( 'init', 'wcpt_latest_jquery' );

// Load Frontend JS Files
add_action( 'init', 'wcpt_js' );

// Load Frontend CSS Files
add_action( 'init', 'wcpt_css' );

// Load Backend JS & CSS Files
add_action( 'admin_enqueue_scripts', 'wcpt_admin_js_css' );
