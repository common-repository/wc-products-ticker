<?php

if(!defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();
	
//All options
$wcpt_optNames = array('widget_wcpt_widget');

foreach ($wcpt_optNames as $wcpt_opt) {
	delete_option($wcpt_opt);
}
