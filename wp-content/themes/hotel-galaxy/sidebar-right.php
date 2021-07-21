<?php 

if ( ! defined( 'ABSPATH' ) ) {	exit; }

if ( is_active_sidebar( 'sidebar-primary' ) ){ 

	dynamic_sidebar( 'sidebar-primary' );
	
} else{
	
	hotelgalaxy_widget_search();
}

?>
