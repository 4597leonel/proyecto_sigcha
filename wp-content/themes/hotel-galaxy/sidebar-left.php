<?php 

if ( ! defined( 'ABSPATH' ) ) {	exit; }

if ( is_active_sidebar( 'sidebar-left' ) ){ 	
	
	dynamic_sidebar( 'sidebar-left' );

} else{

	hotelgalaxy_widget_search();
}

?>
