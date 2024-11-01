<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* 
* Load WordPress Latest jQuery
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/
function wcpt_latest_jQuery() {
    if(!is_admin() ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script("jquery-effects-core");
	}
}

/* 
* Load Plugin Frontend Js Files
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/

function wcpt_js() {
	if (!is_admin()) {
    	wp_enqueue_script( 'wcpt-ticker', WCPT_TICKER_JS , array('jquery'), '', false);
    	wp_enqueue_script( 'wcpt-easing', WCPT_EASING_JS , array('jquery'), '', false);
	}
}

/* 
* Load ALl Plugin CSS Stylesheet
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/

function wcpt_css() {
	if(!is_admin()) {
		wp_enqueue_style( 'wcpt-style', WCPT_STYLE_CSS);
	}

}


/* 
* Load Plugin Backend Js & CSS Files
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/

function wcpt_admin_js_css() {
	if (is_admin()) {
		wp_enqueue_script( 'wcpt-accordion-js', WCPT_ACCORDION_JS , array('jquery'), 1.0, false);
		wp_enqueue_style( 'wcpt-accordion', WCPT_ADMIN_ACCORDION_CSS);
	}
}

/* 
* Register Ticker Widget
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author AmityThemes
*/

function WC_Product_Ticker() {
	register_widget( 'WC_Product_Widget_Ticker' );

}

