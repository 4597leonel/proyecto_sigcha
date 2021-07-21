<?php

if ( ! defined( 'ABSPATH' ) ) {	exit; }

function hotelgalaxy_add_class( $context, $class = '' ) {

	echo 'class="' . join( ' ', hotelgalaxy_class_get_element( $context, $class ) ) . '"'; 
}

function hotelgalaxy_class_get_element( $context, $class = '' ) {
	
	$classes = array();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}

		$classes = array_merge( $classes, $class );
	}

	$classes = array_map( 'esc_attr', $classes );

	return apply_filters( "hotelgalaxy_{$context}_class", $classes, $class );
}

// service column
if ( ! function_exists( 'hotelgalaxy_home_service_column_classes' ) ) {

	add_filter( 'hotelgalaxy_home_service_column_class', 'hotelgalaxy_home_service_column_classes' );
	
	function hotelgalaxy_home_service_column_classes( $classes ) {		

		$column = hotelgalaxy_get_option('home_service_widget_column');

		$classes[] = 'col-sm-6';
		$classes[] = 'wow fadeInUp';
		$classes[] = esc_attr( $column );

		return $classes;
	}
}


// blog column class
if ( ! function_exists( 'hotelgalaxy_home_blog_column_classes' ) ) {

	add_filter( 'hotelgalaxy_home_blog_column_class', 'hotelgalaxy_home_blog_column_classes' );
	
	function hotelgalaxy_home_blog_column_classes( $classes ) {		

		$column =hotelgalaxy_get_option('home_blog_column');

		$classes[] = 'col-sm-6';
		$classes[] = 'wow fadeInUp';
		$classes[] = esc_attr( $column );

		return $classes;
	}
}

// room column
if ( ! function_exists( 'hotelgalaxy_home_room_column_classes' ) ) {

	add_filter( 'hotelgalaxy_home_room_column_class', 'hotelgalaxy_home_room_column_classes' );
	
	function hotelgalaxy_home_room_column_classes( $classes ) {			

		$column = hotelgalaxy_get_option('home_room_column');

		$classes[] = 'hg-room-grid-item';
		
		$classes[] = 'room-isotope-item';
		$classes[] = 'wow fadeInUp';

		$classes[] = 'col-sm-6';

		$classes[] = esc_attr( $column );

		return $classes;
	}
}

if ( ! function_exists( 'hotelgalaxy_header_layout_classes' ) ) {

	add_filter( 'hotelgalaxy_header_layout_class', 'hotelgalaxy_header_layout_classes' );
	
	function hotelgalaxy_header_layout_classes( $classes ) {			

		$header = hotelgalaxy_get_option( 'header_layout'). '-header';	
		
		$classes[] = esc_attr( $header );

		return $classes;
	}
}

if ( ! function_exists( 'hotelgalaxy_slider_layout_classes' ) ) {

	add_filter( 'hotelgalaxy_slider_layout_class', 'hotelgalaxy_slider_layout_classes' );
	
	function hotelgalaxy_slider_layout_classes( $classes ) {

		if(!function_exists('hotelgalaxy_get_option')){
			return false;
		}			

		$slider = hotelgalaxy_get_option('slider_layout'). '-slider';

		$classes[] = esc_attr( $slider );	

		if( 'one' == hotelgalaxy_get_option('slider_layout') ){

			$classes[] = 'hg-home-slider';
			$classes[] = 'owl-carousel';
			$classes[] = 'owl-theme';	
			$classes[] = 'animate__animated';		
			$classes[] = 'wow fadeInUp';	
			

		}else if( 'two' == hotelgalaxy_get_option('slider_layout') ){

			$classes[] = 'swiper-container';
			$classes[] = 'wow fadeInUp';
			
		}else if( 'three' == hotelgalaxy_get_option('slider_layout') ){

			$classes[] = 'hg-home-slider';
			$classes[] = 'owl-carousel';
			$classes[] = 'fxSoftScale';			
			$classes[] = 'wow fadeInUp';			
		}

		return $classes;
	}
}

?>