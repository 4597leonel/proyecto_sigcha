<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if(! function_exists('hotelgalaxy_theme_support')){


	add_action( 'after_setup_theme', 'hotelgalaxy_theme_support' ); 	

	function hotelgalaxy_theme_support(){		

		load_theme_textdomain( 'hotel-galaxy');

		add_theme_support( 'automatic-feed-links');

		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'woocommerce' );

		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'post-formats', array( 
			'aside', 
			'image', 
			'video', 
			'quote', 
			'link', 
			'status' 
		) );

		add_theme_support( 'title-tag' );

		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		add_theme_support( 'customize-selective-refresh-widgets' );
		
		add_theme_support( 'align-wide' );

		add_theme_support( 'responsive-embeds' );		

		
		add_theme_support('custom-logo',
			array(
				'height'      => 70,
				'width'       => 350,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);		

	// Set post thumbnail size.
		set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
		add_image_size( 'hotelgalaxy-fullscreen', 1980, 9999 );

	// If the retina setting is active, double the recommended width and height.	

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

	// Register primary menu.

		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'hotel-galaxy'),
		) );


		if ( is_customize_preview() ) {
			require HOTEL_PARENT_INC_DIR . '/starter-content.php';
			add_theme_support( 'starter-content', hotel_galaxy_one_get_starter_content() );
		}
	// Pixels

		global $content_width;

		if ( ! isset( $content_width ) ) {

			$content_width = 1200; 
		}
	}

}


function hotelgalaxy_hex_To_rgba($color, $opacity = false) {
	
	$default = 'rgb(0,0,0)';
	
	//Return default if no color provided
	if(empty($color))
		return $default; 
	
	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	
        //Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}
	
        //Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);
	
        //Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}
	
        //Return rgb(a) color string
	return $output;
}

// global variable define 
function hotelgalaxy_theme_option_settings(){

	global $hotelgalaxy_settings;

	$hotelgalaxy_settings = get_option( 'hotel_galaxy_option', array() );
	
}

add_action('after_setup_theme', 'hotelgalaxy_theme_option_settings');
add_action('wp_head', 'hotelgalaxy_theme_option_settings');


function hotelgalaxy_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'hotelgalaxy_classic_editor_styles' );

?>