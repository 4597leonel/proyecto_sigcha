<?php 

if ( ! defined( 'ABSPATH' ) ) {	exit; }

define( 'Hotelsydney_Version', '1.0.4' );

add_action('wp_enqueue_scripts', 'Hotelsydney_Scripts', 999 );

function Hotelsydney_Scripts() {

	$parent_style = 'hotelgalaxy_style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );	

	if(!defined('HG_PREMIUM_VERSION')){

		wp_enqueue_style( 'hotelsydney-header', get_stylesheet_directory_uri() .'/assets/css/header.css' );

		wp_enqueue_style( 'hotelsydney-slider', get_stylesheet_directory_uri() .'/assets/css/slider.css' );
	}

	wp_enqueue_style( 'hotelsydney-style', get_stylesheet_uri(), array( $parent_style ) );	
}

add_action( 'after_switch_theme', 'Hotelsydney_Migrate_Settings', 10 );

function Hotelsydney_Migrate_Settings() {

	if(!defined('HG_PREMIUM_VERSION') ){		

		$option = get_option('hotel_galaxy_option');		
		$spacing = get_option('hg_spacing_settings');

		$new_option = array();

		$new_option['theme_color'] = '#d82c2c';	

		$new_option['seprator_color_before'] = '#d82c2c';		

		$new_option['header_layout'] = 'classic';			

		$new_option['slider_layout'] = 'one';

		$new_option['is_carousel_background_overlay'] = false;

		$new_option['infobar_background_color'] = '#04102d';

		$new_option['link_color'] = '#d82c2c';

		$new_option['link_color_visited'] = '#d82c2c';

		$new_option['entry_meta_link_color_hover'] = '#d82c2c';

		$new_option['blog_post_title_hover_color'] = '#d82c2c';

		$new_option['navigation_background_current_color'] = '#d82c2c';

		$new_option['navigation_background_hover_color'] = '#d82c2c';

		$new_option['sidebar_widget_top_border_color'] = '#d82c2c';

		$new_option['button_background_color'] = '#d82c2c';

		$new_option['footer_icon_bar_background_color'] = '#d82c2c';

		$new_option['footer_widget_title_underline_color'] = '#d82c2c';

		$new_option['back_to_top_background_color'] = '#d82c2c';

		if( !empty( $new_option ) ){

			$new_settings = wp_parse_args( $new_option, $option );				

			update_option( 'hotel_galaxy_option', $new_settings);

		}		

		// spacing		

		$new_spacing = array();

		$new_spacing['button_radius_top_left'] = '40';	
		$new_spacing['button_radius_top_right'] = '40';	
		$new_spacing['button_radius_bottom_left'] = '40';	
		$new_spacing['button_radius_bottom_right'] = '40';

		if( !empty( $new_spacing ) ){

			$new_spacing_settings = wp_parse_args( $new_spacing, $spacing );		

			update_option( 'hg_spacing_settings', $new_spacing_settings);

		}	
		
	}
}

?>