<?php 

if ( ! defined( 'ABSPATH' ) ) {	exit; }

add_action( 'admin_init', 'Hotelgalaxy_DB_Migrate', 5 );

function Hotelgalaxy_DB_Migrate() {

	$option = get_option('hotel_galaxy_option');	

	if( !empty($option) ){

		$new_option = array();

		if(has_header_image() && empty($option['header_background_image'])){		

			$new_option['header_background_image'] = esc_attr(get_header_image());
		}

		if(isset($option['header_hide'])){		

			$new_option['sticky_menu'] = $option['header_hide'];
			unset($option['header_hide']);
		}

		if(isset($option['address'])){

			$new_option['information_title_1'] = __('Address','hotel-galaxy');

			$new_option['information_text_1'] = $option['address'];
			unset($option['address']);
		}

		if(isset($option['reservation_line'])){

			$new_option['information_title_2'] = __('Reservation','hotel-galaxy');

			$new_option['information_text_2'] = $option['reservation_line'];
			unset($option['reservation_line']);
		}

		if(isset($option['facebook_link'])){

			$new_option['socialmedia_icon_1'] = 'fa fa-facebook';

			$new_option['socialmedia_url_1'] = $option['facebook_link'];
			unset($option['facebook_link']);
		}

		if(isset($option['twitter_link'])){

			$new_option['socialmedia_icon_2'] = 'fa fa-twitter';

			$new_option['socialmedia_url_2'] = $option['twitter_link'];
			unset($option['twitter_link']);
		}

		if(isset($option['skyup_link'])){

			$new_option['socialmedia_icon_3'] = 'fa fa-skype';

			$new_option['socialmedia_url_3'] = $option['skyup_link'];
			unset($option['skyup_link']);
		}

		if(isset($option['googleplus_link'])){

			$new_option['socialmedia_icon_4'] = 'fa fa-google-plus';

			$new_option['socialmedia_url_4'] = $option['googleplus_link'];
			unset($option['googleplus_link']);
		}

		if(isset($option['service_show'])){		

			$new_option['is_home_service_section'] = $option['service_show'];
			unset($option['service_show']);
		}

		if(isset($option['service_title'])){		

			$new_option['home_service_section_header'] = $option['service_title'];
			unset($option['service_title']);
		}

		if(isset($option['service_description'])){		

			$new_option['home_service_section_description'] = $option['service_description'];
			unset($option['service_description']);
		}

		if(isset($option['home_service_section_description'])){		

			$new_option['home_service_section_sub_header'] = $option['home_service_section_description'];		
			unset($option['home_service_section_description']);
		}

		if(isset($option['room_sec_title'])){		

			$new_option['home_room_section_header'] = $option['room_sec_title'];
			unset($option['room_sec_title']);
		}
		if(isset($option['room_sec_show'])){		

			$new_option['is_home_room_section'] = $option['room_sec_show'];
			unset($option['room_sec_show']);
		}

		if(isset($option['room_sec_description'])){		

			$new_option['home_room_section_sub_header'] = $option['room_sec_description'];		
			unset($option['room_sec_description']);
		}

		if(isset($option['blog_show'])){		

			$new_option['is_home_blog_section'] = $option['blog_show'];		
			unset($option['blog_show']);
		}

		if(isset($option['blog_show'])){		

			$new_option['is_home_blog_section'] = $option['blog_show'];		
			unset($option['blog_show']);
		}

		if(isset($option['blog_title'])){		

			$new_option['home_blog_section_header'] = $option['blog_title'];		
			unset($option['blog_title']);
		}

		if(isset($option['blog_description'])){		

			$new_option['home_blog_section_sub_header'] = $option['blog_description'];		
			unset($option['blog_description']);
		}

		if(isset($option['shortcode_show'])){		

			$new_option['is_home_shortcode_section'] = $option['shortcode_show'];		
			unset($option['shortcode_show']);
		}

		if(isset($option['shortcode_title'])){		

			$new_option['home_shortcode_section_header'] = $option['shortcode_title'];		
			unset($option['shortcode_title']);
		}

		if(isset($option['shortcode_description'])){		

			$new_option['home_shortcode_section_sub_header'] = $option['shortcode_description'];		
			unset($option['shortcode_description']);
		}

		if(isset($option['home_team_section_description'])){		

			$new_option['home_team_section_sub_header'] = $option['home_team_section_description'];		
			unset($option['home_team_section_description']);
		}

		if(isset($option['slider_sec_btn'])){		

			$new_option['slider_button_text'] = $option['slider_sec_btn'];		
			unset($option['slider_sec_btn']);
		}		


		if(!empty($new_option)){

			$new_settings = wp_parse_args( $new_option, $option );		

			update_option( 'hotel_galaxy_option', $new_settings);
		}	

	}
}


add_action( 'after_switch_theme', 'Hotelgalaxy_Migrate_Settings', 9 );

function Hotelgalaxy_Migrate_Settings() {

	if(!defined('HG_PREMIUM_VERSION') ){		

		$option = get_option('hotel_galaxy_option');		
		$spacing = get_option('hg_spacing_settings');

		$new_option = array();

		$new_option['header_layout'] = 'default';

		$new_option['slider_layout'] = 'one';

		$new_option['is_carousel_background_overlay'] = true;

		$new_option['theme_color'] = '#fea116';

		$new_option['infobar_background_color'] = '#fea116';

		$new_option['link_color'] = '#fea116';

		$new_option['link_color_visited'] = '#fea116';		

		$new_option['entry_meta_link_color_hover'] = '#fea116';

		$new_option['blog_post_title_hover_color'] = '#fea116';

		$new_option['navigation_background_current_color'] = '#fea116';

		$new_option['navigation_background_hover_color'] = '#fea116';

		$new_option['sidebar_widget_top_border_color'] = '#fea116';

		$new_option['button_background_color'] = '#fea116';

		$new_option['footer_icon_bar_background_color'] = '#fea116';
		
		$new_option['footer_widget_title_underline_color'] = '#fea116';	
				
		$new_option['back_to_top_background_color'] = '#fea116';			

		if( !empty( $new_option ) ){

			$new_settings = wp_parse_args( $new_option, $option );				

			update_option( 'hotel_galaxy_option', $new_settings);

		}
		
		// spacing		

		$new_spacing = array();

		$new_spacing['button_radius_top_left'] = '0';	
		$new_spacing['button_radius_top_right'] = '0';	
		$new_spacing['button_radius_bottom_left'] = '0';	
		$new_spacing['button_radius_bottom_right'] = '0';

		if( !empty( $new_spacing ) ){

			$new_spacing_settings = wp_parse_args( $new_spacing, $spacing );		

			update_option( 'hg_spacing_settings', $new_spacing_settings);

		}	
		
	}
}
?>