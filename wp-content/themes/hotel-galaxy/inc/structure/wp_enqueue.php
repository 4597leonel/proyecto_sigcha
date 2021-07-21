<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_action('wp_enqueue_scripts', 'hotelgalaxy_theme_styles'); 

function hotelgalaxy_theme_styles(){

	wp_enqueue_script('jquery');

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// fontawesome
	wp_enqueue_style('hg-fontawesome-style', get_template_directory_uri().'/assets/css/fontawesome.css', array(), HotelGalaxy_Version );

	// wow

	wp_enqueue_script('hg-wow',get_template_directory_uri() .'/assets/js/wow.min.js', array('jquery'), HotelGalaxy_Version);

	// bootstrap
	wp_enqueue_style('hg-bootstrap-style', get_template_directory_uri().'/assets/css/bootstrap.css');	  

	wp_enqueue_script('hg-bootstrap',get_template_directory_uri().'/assets/js/bootstrap.js', array(), HotelGalaxy_Version);	

	// owl

	wp_enqueue_style('hg-owl-carousel', get_template_directory_uri().'/assets/css/owl.carousel.min.css', array(), HotelGalaxy_Version );	

	wp_enqueue_script('hg-owl-carousel',get_template_directory_uri() .'/assets/js/owl.carousel.min.js', array('jquery'), HotelGalaxy_Version);	

	// animate
	wp_enqueue_style('hg-animate', get_template_directory_uri().'/assets/css/animate.min.css', array(), HotelGalaxy_Version );	

	wp_enqueue_style('hotelgalaxy-main', get_template_directory_uri() . '/assets/css/main.css');

	wp_enqueue_style('hotelgalaxy-contact-form', get_template_directory_uri() . '/assets/css/contact-form.css');
	
	wp_enqueue_style('hotelgalaxy_style', get_stylesheet_uri(), array(), HotelGalaxy_Version );

	wp_enqueue_script('hg-custom',get_template_directory_uri() .'/assets/js/custom.js', array('jquery'), HotelGalaxy_Version);	


	wp_localize_script( 'hg-custom', 'hg_vars', array( 'sticky_menu'   => ( hotelgalaxy_get_option('sticky_menu') === 'false') ? false : hotelgalaxy_get_option('sticky_menu') ) );	
	
}


add_action('wp_enqueue_scripts', 'hotelgalaxy_theme_styles_on_requirment');

function hotelgalaxy_theme_styles_on_requirment(){	

	if( !defined( 'HG_SLIDER_ADDON_VERSION' ) ){

		$isNav = hotelgalaxy_get_option('is_main_slider_nav');
		$speed = hotelgalaxy_get_option('main_slider_speed');

		wp_enqueue_style('hg-slider', get_template_directory_uri().'/assets/css/slider.css', array(), HotelGalaxy_Version );

		wp_enqueue_script('hg-slider',get_template_directory_uri() .'/assets/js/slider.js', array('jquery'), HotelGalaxy_Version);

		wp_localize_script( 'hg-slider', 'hgSlider', array(
			'isNav' => $isNav,
			'speed' => $speed
		) );
	}	
	
}

// 
function hotelgalaxy_admin_enqueue_scripts(){

	wp_enqueue_style('hotelgalaxy-admin-style', get_template_directory_uri() . '/assets/css/admin/admin.css');
	
	wp_enqueue_script( 'hotelgalaxy-admin-script', get_template_directory_uri() . '/assets/js/admin-script.js', array( 'jquery' ), HotelGalaxy_Version , true );

    wp_localize_script( 'hotelgalaxy-admin-script', 'hotelgalaxy_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
add_action( 'admin_enqueue_scripts', 'hotelgalaxy_admin_enqueue_scripts' );

?>