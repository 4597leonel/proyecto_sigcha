<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$wp_customize->add_section('body_color',
	array(
		'title' => __( 'Body', 'hotel-galaxy'),
		'capability' => 'edit_theme_options',
		'priority' => 1,
		'panel' => 'hotelgalaxy_colors_panel'
	)
);

if(!defined('HG_BACKGROUND_ADDON_VERSION')){

	// Background color
	$wp_customize->add_setting(
		'hotel_galaxy_option[body_background_color]', array(
			'default' => $color_default['body_background_color'],
			'type' => 'option',
			'priority' => 1,
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[body_background_color]',
			array(
				'label' => __( 'Background Color', 'hotel-galaxy'),
				'section' => 'body_color',
				'settings' => 'hotel_galaxy_option[body_background_color]',
			)
		)
	);
}


// text color
$wp_customize->add_setting(
	'hotel_galaxy_option[text_color]', array(
		'default' => $color_default['text_color'],
		'type' => 'option',
		'priority' => 2,
		'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'hotel_galaxy_option[text_color]',
		array(
			'label' => __( 'Text Color', 'hotel-galaxy'),
			'section' => 'body_color',
			'settings' => 'hotel_galaxy_option[text_color]',
		)
	)
);

// link color
$wp_customize->add_setting(
	'hotel_galaxy_option[link_color]', array(
		'default' => $color_default['link_color'],
		'type' => 'option',
		'priority' => 3,
		'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
		'transport' => 'postMessage',
	)
);


$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'hotel_galaxy_option[link_color]',
		array(
			'label' => __( 'Link Color', 'hotel-galaxy'),
			'section' => 'body_color',
			'settings' => 'hotel_galaxy_option[link_color]',
		)
	)
);

// link hover color
$wp_customize->add_setting(
	'hotel_galaxy_option[link_color_hover]', array(
		'default' => $color_default['link_color_hover'],
		'type' => 'option',
		'priority' => 4,
		'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
		'transport' => 'postMessage',
	)
);


$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'hotel_galaxy_option[link_color_hover]',
		array(
			'label' => __( 'Link Hover Color', 'hotel-galaxy'),
			'section' => 'body_color',
			'settings' => 'hotel_galaxy_option[link_color_hover]',
		)
	)
);

// link color visited
$wp_customize->add_setting(
	'hotel_galaxy_option[link_color_visited]', array(
		'default' => $color_default['link_color_visited'],
		'type' => 'option',
		'priority' => 5,
		'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
		'transport' => 'postMessage',
	)
);


$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'hotel_galaxy_option[link_color_visited]',
		array(
			'label' => __( 'Link Color Visited', 'hotel-galaxy'),
			'section' => 'body_color',
			'settings' => 'hotel_galaxy_option[link_color_visited]',
		)
	)
);


// end

if( ! defined('HG_COLOR_ADDON_VERSION')){

	// header color

	if(!$wp_customize->get_section('header_color_section')){

		$wp_customize->add_section(
			'header_color_section',
			array(
				'title' => __( 'Header', 'hotel-galaxy' ),
				'capability' => 'edit_theme_options',
				'priority' => 1,
				'panel' => 'hotelgalaxy_colors_panel'
			)
		);

	}

	// header background color
	$wp_customize->add_setting(
		'hotel_galaxy_option[header_background_color]', array(
			'default' => $color_default['header_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',			
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[header_background_color]',
			array(
				'label' => __( 'Background', 'hotel-galaxy'),
				'section' => 'header_color_section',
				'settings' => 'hotel_galaxy_option[header_background_color]',
				'priority' => 1,
			)
		)
	);

	// site title color
	$wp_customize->add_setting(
		'hotel_galaxy_option[site_title_color]', array(
			'default' => $color_default['site_title_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',			
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[site_title_color]',
			array(
				'label' => __( 'Site Title', 'hotel-galaxy'),
				'section' => 'header_color_section',
				'settings' => 'hotel_galaxy_option[site_title_color]',
				'priority' => 1,
			)
		)
	);

	// site tagline color
	$wp_customize->add_setting(
		'hotel_galaxy_option[site_tagline_color]', array(
			'default' => $color_default['site_tagline_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',			
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[site_tagline_color]',
			array(
				'label' => __( 'Site Tagline', 'hotel-galaxy'),
				'section' => 'header_color_section',
				'settings' => 'hotel_galaxy_option[site_tagline_color]',
				'priority' => 1,
			)
		)
	);

// primary navigation color

	$wp_customize->add_section(
		'primary_navigation_color',
		array(
			'title' => __( 'Primary Navigation', 'hotel-galaxy'),
			'capability' => 'edit_theme_options',
			'priority' => 1,
			'panel' => 'hotelgalaxy_colors_panel'
		)
	);

// primary navigation background color

	$wp_customize->add_setting(
		'hotel_galaxy_option[navigation_background_hover_color]', array(
			'default' => $color_default['navigation_background_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',			
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[navigation_background_hover_color]',
			array(
				'label' => __( 'Menu Hover Background', 'hotel-galaxy'),
				'section' => 'primary_navigation_color',
				'settings' => 'hotel_galaxy_option[navigation_background_hover_color]',
				'priority' => 1,
			)
		)
	);

	// current navigation background color

	$wp_customize->add_setting(
		'hotel_galaxy_option[navigation_background_current_color]', array(
			'default' => $color_default['navigation_background_current_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',			
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[navigation_background_current_color]',
			array(
				'label' => __( 'Current Menu Background', 'hotel-galaxy'),
				'section' => 'primary_navigation_color',
				'settings' => 'hotel_galaxy_option[navigation_background_current_color]',
				'priority' => 1,
			)
		)
	);

	// current navigation text color

	$wp_customize->add_setting(
		'hotel_galaxy_option[navigation_text_current_color]', array(
			'default' => $color_default['navigation_text_current_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',			
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[navigation_text_current_color]',
			array(
				'label' => __( 'Current Menu Text', 'hotel-galaxy'),
				'section' => 'primary_navigation_color',
				'settings' => 'hotel_galaxy_option[navigation_text_current_color]',
				'priority' => 1,
			)
		)
	);

	//navigation text color
	$wp_customize->add_setting(
		'hotel_galaxy_option[navigation_text_color]',
		array(
			'default'     => $color_default['navigation_text_color'],
			'type'        => 'option',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[navigation_text_color]',
			array(
				'label'     => __( 'Menu Text', 'hotel-galaxy' ),
				'section'   => 'primary_navigation_color',
				'settings'  => 'hotel_galaxy_option[navigation_text_color]',				
				'priority' => 2,
			)
		)
	);

	//navigation text hover color
	$wp_customize->add_setting(
		'hotel_galaxy_option[navigation_text_hover_color]',
		array(
			'default'     => $color_default['navigation_text_hover_color'],
			'type'        => 'option',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[navigation_text_hover_color]',
			array(
				'label'     => __( 'Menu Text hover', 'hotel-galaxy' ),
				'section'   => 'primary_navigation_color',
				'settings'  => 'hotel_galaxy_option[navigation_text_hover_color]',				
				'priority' => 3,
			)
		)
	);

}
// theme color
$wp_customize->add_section(
	'theme_colors',
	array(
		'title' => __( 'Theme Color', 'hotel-galaxy'),
		'capability' => 'edit_theme_options',
		'priority' => 1,
		'panel' => 'hotelgalaxy_colors_panel'
	)
);

// Theme color
$wp_customize->add_setting(
	'hotel_galaxy_option[theme_color]', array(
		'default' => $color_default['theme_color'],
		'type' => 'option',
		'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
		'priority' => 1,
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'hotel_galaxy_option[theme_color]',
		array(
			'label' => __( 'Theme Color', 'hotel-galaxy'),
			'section' => 'theme_colors',
			'settings' => 'hotel_galaxy_option[theme_color]',
		)
	)
);


if(! $wp_customize->get_setting('hotel_galaxy_option[infobar_background_color]')){	

	$wp_customize->add_setting(
		'hotel_galaxy_option[infobar_background_color]', array(
			'default' => $color_default['infobar_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[seprator_color]')){	

	$wp_customize->add_setting(
		'hotel_galaxy_option[seprator_color]', array(
			'default' => $color_default['seprator_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[seprator_color_before]')){	

	$wp_customize->add_setting(
		'hotel_galaxy_option[seprator_color_before]', array(
			'default' => $color_default['seprator_color_before'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[home_room_button_background_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[home_room_button_background_color]', array(
			'default' => $color_default['home_room_button_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);
}

if(! $wp_customize->get_setting('hotel_galaxy_option[back_to_top_background_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[back_to_top_background_color]', array(
			'default' => $color_default['back_to_top_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);
}

if(! $wp_customize->get_setting('hotel_galaxy_option[button_background_color]')){
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_background_color]', array(
			'default' => $color_default['button_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[button_border_color]')){
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_border_color]', array(
			'default' => $color_default['button_border_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[pagination_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[pagination_color]', array(
			'default' => $color_default['pagination_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[sidebar_widget_top_border_color]')){
	
	$wp_customize->add_setting(
		'hotel_galaxy_option[sidebar_widget_top_border_color]', array(
			'default' => $color_default['sidebar_widget_top_border_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[footer_widget_title_underline_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[footer_widget_title_underline_color]', array(
			'default' => $color_default['footer_widget_title_underline_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[footer_widget_link_hover_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[footer_widget_link_hover_color]', array(
			'default' => $color_default['footer_widget_link_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[sidebar_tag_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[sidebar_tag_color]', array(
			'default' => $color_default['sidebar_tag_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[sidebar_widget_link_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[sidebar_widget_link_color]', array(
			'default' => $color_default['sidebar_widget_link_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

}

if(! $wp_customize->get_setting('hotel_galaxy_option[footer_icon_bar_background_color]')){

	$wp_customize->add_setting(
		'hotel_galaxy_option[footer_icon_bar_background_color]', array(
			'default' => $color_default['footer_icon_bar_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);
}

// end

if(! defined('HG_COLOR_ADDON_VERSION')){
	// content color
	$wp_customize->add_section(
		'content_colors',
		array(
			'title' => __( 'Content', 'hotel-galaxy'),
			'capability' => 'edit_theme_options',
			'priority' => 2,
			'panel' => 'hotelgalaxy_colors_panel'
		)
	);

// 
	$wp_customize->add_setting(
		'hotel_galaxy_option[blog_post_title_color]', array(
			'default' => $color_default['blog_post_title_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);


	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[blog_post_title_color]',
			array(
				'label' => __( 'Blog Post Title', 'hotel-galaxy'),
				'section' => 'content_colors',
				'settings' => 'hotel_galaxy_option[blog_post_title_color]',
			)
		)
	);



// 
	$wp_customize->add_setting(
		'hotel_galaxy_option[blog_post_title_hover_color]', array(
			'default' => $color_default['blog_post_title_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);


	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[blog_post_title_hover_color]',
			array(
				'label' => __( 'Blog Post Title Hover', 'hotel-galaxy'),
				'section' => 'content_colors',
				'settings' => 'hotel_galaxy_option[blog_post_title_hover_color]',
			)
		)
	);

	$wp_customize->add_section(
		'button_colors',
		array(
			'title' => __( 'Button', 'hotel-galaxy'),
			'capability' => 'edit_theme_options',
			'priority' => 2,
			'panel' => 'hotelgalaxy_colors_panel'
		)
	);

	// button color
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_text_color]', array(
			'default' => $color_default['button_text_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);


	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[button_text_color]',
			array(
				'label' => __( 'Color', 'hotel-galaxy'),
				'section' => 'button_colors',
				'settings' => 'hotel_galaxy_option[button_text_color]',
			)
		)
	);
// button hover color
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_text_hover_color]', array(
			'default' => $color_default['button_text_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[button_text_hover_color]',
			array(
				'label' => __( 'Hover Color', 'hotel-galaxy'),
				'section' => 'button_colors',
				'settings' => 'hotel_galaxy_option[button_text_hover_color]',
			)
		)
	);

// button bg color
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_background_color]', array(
			'default' => $color_default['button_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);


	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[button_background_color]',
			array(
				'label' => __( 'Background', 'hotel-galaxy'),
				'section' => 'button_colors',
				'settings' => 'hotel_galaxy_option[button_background_color]',
			)
		)
	);

// button bg hover color
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_background_hover_color]', array(
			'default' => $color_default['button_background_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);


	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[button_background_hover_color]',
			array(
				'label' => __( 'Background Hover', 'hotel-galaxy'),
				'section' => 'button_colors',
				'settings' => 'hotel_galaxy_option[button_background_hover_color]',
			)
		)
	);

	// button border color
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_border_color]', array(
			'default' => $color_default['button_border_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);


	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[button_border_color]',
			array(
				'label' => __( 'Border', 'hotel-galaxy'),
				'section' => 'button_colors',
				'settings' => 'hotel_galaxy_option[button_border_color]',
			)
		)
	);
// button hover border
	$wp_customize->add_setting(
		'hotel_galaxy_option[button_border_hover_color]', array(
			'default' => $color_default['button_border_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'hotelgalaxy_sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hotel_galaxy_option[button_border_hover_color]',
			array(
				'label' => __( 'Border Hover', 'hotel-galaxy'),
				'section' => 'button_colors',
				'settings' => 'hotel_galaxy_option[button_border_hover_color]',
			)
		)
	);

}


if(!defined('HG_COLOR_ADDON_VERSION')){

	// footer color
	$wp_customize->add_section(
		'footer_colors',
		array(
			'title' => __( 'Footer', 'hotel-galaxy'),
			'capability' => 'edit_theme_options',
			'priority' => 20,
			'panel' => 'hotelgalaxy_colors_panel'
		)
	);

	// inner color
	$wp_customize->add_setting(
		'hotel_galaxy_option[footer_background_color]', array(
			'capability'     => 'edit_theme_options',
			'default' => $color_default['footer_background_color'],
			'type' => 'option',	
			'sanitize_callback'=>'hotelgalaxy_sanitize_hex_color',	
		)
	);

	$wp_customize->add_control(	new WP_Customize_Color_Control(	$wp_customize,'hotel_galaxy_option[footer_background_color]', 
		array(
			'label'      => __( 'Footer Background', 'hotel-galaxy'),
			'section'    => 'footer_colors',			
			'settings'   => 'hotel_galaxy_option[footer_background_color]',
		) ) 
);


// outer footer color
	$wp_customize->add_setting(
		'hotel_galaxy_option[footer_bar_background_color]', array(
			'capability'     => 'edit_theme_options',
			'default' => $color_default['footer_bar_background_color'],
			'type' => 'option',	
			'sanitize_callback'=>'hotelgalaxy_sanitize_hex_color',	
		)
	);

	$wp_customize->add_control(	new WP_Customize_Color_Control(	$wp_customize,'hotel_galaxy_option[footer_bar_background_color]', 
		array(
			'label'      => __( 'Footer Copyright Bar Background', 'hotel-galaxy'),
			'section'    => 'footer_colors',			
			'settings'   => 'hotel_galaxy_option[footer_bar_background_color]',
		) ) 
);

}





// blog bg color
if(! defined('HG_COLOR_ADDON_VERSION')){ 

	if(!$wp_customize->get_section('blog_color_section')){

		$wp_customize->add_section(
			'blog_color_section',
			array(
				'title' => __( 'Blog', 'hotel-galaxy' ),
				'capability' => 'edit_theme_options',
				'priority' => 2,
				'panel' => 'hotelgalaxy_colors_panel'
			)
		);
	}
	// background
	$wp_customize->add_setting(
		'hotel_galaxy_option[home_blog_background_color]', array(
			'capability'     => 'edit_theme_options',
			'default' => $color_default['home_blog_background_color'],
			'type' => 'option',	
			'sanitize_callback'=>'hotelgalaxy_sanitize_hex_color',	
		)
	);

	$wp_customize->add_control(	new WP_Customize_Color_Control(	$wp_customize,'hotel_galaxy_option[home_blog_background_color]', 
		array(
			'label'      => __( 'Background', 'hotel-galaxy'),
			'section'    => 'blog_color_section',			
			'settings'   => 'hotel_galaxy_option[home_blog_background_color]',
		) )
);

	// Header color
	$wp_customize->add_setting(
		'hotel_galaxy_option[home_blog_header_title_color]', array(
			'capability'     => 'edit_theme_options',
			'default' => $color_default['home_blog_header_title_color'],
			'type' => 'option',	
			'sanitize_callback'=>'hotelgalaxy_sanitize_hex_color',	
		)
	);

	$wp_customize->add_control(	new WP_Customize_Color_Control(	$wp_customize,'hotel_galaxy_option[home_blog_header_title_color]', 
		array(
			'label'      => __( 'Header', 'hotel-galaxy'),
			'section'    => 'blog_color_section',			
			'settings'   => 'hotel_galaxy_option[home_blog_header_title_color]',
		) )
);

	// sub header color
	$wp_customize->add_setting(
		'hotel_galaxy_option[home_blog_header_description_color]', array(
			'capability'     => 'edit_theme_options',
			'default' => $color_default['home_blog_header_description_color'],
			'type' => 'option',	
			'sanitize_callback'=>'hotelgalaxy_sanitize_hex_color',	
		)
	);

	$wp_customize->add_control(	new WP_Customize_Color_Control(	$wp_customize,'hotel_galaxy_option[home_blog_header_description_color]', 
		array(
			'label'      => __( 'Sub Header', 'hotel-galaxy'),
			'section'    => 'blog_color_section',			
			'settings'   => 'hotel_galaxy_option[home_blog_header_description_color]',
		) )
);

}

?>