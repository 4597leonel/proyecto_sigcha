<?php 

if ( ! defined( 'ABSPATH' ) ) { exit; }

function hotelgalaxy_current_template_name(){

	global $template;		

	$template_name = basename( str_replace(".php","", $template ) );

	return ('template-homepage' ==  $template_name) ? 'home-default' : basename( $template_name );
}

// 
function hotelgalaxy_get_option( $key ) {

	global $hotelgalaxy_settings;

	$defaults = hotelgalaxy_get_default();

	if ( ! isset( $defaults[ $key ] ) ) {
		return;
	}

	if ( isset( $_REQUEST['wp_customize'] ) ) {

		$hotelgalaxy_settings = wp_parse_args( get_option( 'hotel_galaxy_option', array() ), $defaults );

	}else{

		$hotelgalaxy_settings = wp_parse_args( $hotelgalaxy_settings, $defaults );
	}	

	return $hotelgalaxy_settings[ $key ];
}

// get all settings
function hotelgalaxy_option( $default = null, $key=null ) {

	global $hotelgalaxy_settings;	

	if( $default === null){

		$default = hotelgalaxy_get_default();
	}

	if( $key=== null ){

		$key = 'hotel_galaxy_option';
	}

	if ( isset( $_REQUEST['wp_customize'] ) ) {

		$hotelgalaxy_settings = wp_parse_args( get_option( $key, array() ), $default );

	}else{

		$hotelgalaxy_settings = wp_parse_args( $hotelgalaxy_settings, $default );
	}

	return $hotelgalaxy_settings;
}

// 
add_filter('wp_title', 'hotelgalaxy_custom_wp_title');

function hotelgalaxy_custom_wp_title( $title ) {

	if (is_date()){
		$title = esc_html('Date&nbsp;&#8282;&nbsp;', 'hotel-galaxy');
		$title.= esc_html( get_the_date() );
	}
	
	return $title;
}

function hotelgalaxy_home_section_header( $key, $status = true ){	

	if(!$status){
		return false;
	}

	$hotelgalaxy_settings = hotelgalaxy_option();

	$is_header = isset($hotelgalaxy_settings['is_home_'.$key.'_header']) ? $hotelgalaxy_settings['is_home_'.$key.'_header'] : false;

	$is_sub_header = isset($hotelgalaxy_settings['is_home_'.$key.'_sub_header'])? $hotelgalaxy_settings['is_home_'.$key.'_sub_header'] : false ;

	$is_seprator = isset($hotelgalaxy_settings['is_'.$key.'_seprator']) ? $hotelgalaxy_settings['is_'.$key.'_seprator'] : false ;

	$header = isset($hotelgalaxy_settings['home_'.$key.'_section_header']) ? $hotelgalaxy_settings['home_'.$key.'_section_header'] : '';

	$sub_header = isset($hotelgalaxy_settings['home_'.$key.'_section_sub_header']) ? $hotelgalaxy_settings['home_'.$key.'_section_sub_header'] : '' ;

	if( $is_header || $is_sub_header || $is_seprator ){


		echo '<div class="entry-header section-header slideInUp">';

		if( $is_header){

			$html_header = sprintf( '<h2 clas="header">%s</h2>',  wpautop($header) );
			echo wp_kses_post( $html_header );			
		}

		if( $is_seprator){
			echo '<div class="bar"></div>';
		}

		if( $is_sub_header ){

			$html_sub_header = sprintf( '<p class="sub-header">%s</p>',  wpautop($sub_header) );
			echo wp_kses_post( $html_sub_header );		

		}
		echo '</div>';
	}
}


// 
function hotelgalaxy_media_query( $device ) {

	$mobile = apply_filters( 'hotelgalaxy_mobile_media_query', '(max-width:768px)' );

	$mobile_menu = apply_filters( 'hotelgalaxy_mobile_menu_media_query', $mobile );
	

	$tablet = apply_filters( 'hotelgalaxy_tablet_media_query', '(min-width: 769px) and (max-width: 1024px)' );

	$desktop = apply_filters( 'hotelgalaxy_desktop_media_query', '(min-width:1025px)' );	

	$query = apply_filters( 'hotelgalaxy_media_queries', array(
		'mobile' 		=> $mobile,
		'mobile-menu' 	=> $mobile_menu,
		'tablet' 		=> $tablet,
		'desktop' 		=> $desktop,	
		
		
	) );

	return $query[ $device ];
}

if ( ! function_exists( 'hotelgalaxy_pro_url' ) ) {
	
	function hotelgalaxy_pro_url( $url = 'https://webdzier.com', $trailingslashit = true ) {

		if ( $trailingslashit ) {
			$url = trailingslashit( $url );
		}		

		return esc_url( $url );
	}
}

add_action( 'customize_controls_enqueue_scripts', 'hotelgalaxy_custom_color_palettes' );

/**
 * Adds custom color palettes to wp.color picker.
 */
function hotelgalaxy_custom_color_palettes() {
	$color_palettes = json_encode(
		array(
			'#000000',
			'#ffffff',
			'#a29060',
			'#fea116',
			'#067eff',
			'#a0d049',
			'#fe4c1c'
		)
	);
	wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $color_palettes . ';' );
}


if ( ! function_exists( 'hotelgalaxy_menu_search_icon' ) ) {

	add_filter( 'wp_nav_menu_items', 'hotelgalaxy_menu_search_icon', 10, 2 );
	
	function hotelgalaxy_menu_search_icon( $nav, $args ) {		

		if ( hotelgalaxy_get_option('is_menubar_search_icon') == false ) {
			return $nav;
		}
		
		if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
			return sprintf('%1$s<li class="search-item"><a href="javascript:void(0)" class="header_search_btn"  data-toggle="collapse" data-target="#header_search" aria-label="%2$s"><i class="fa fa-search" aria-hidden="true"></i></a> </li>',
				$nav,
				esc_attr__( 'Search Bar', 'hotel-galaxy' )			
			);
		}

		return $nav;
	}
}

if ( ! function_exists( 'hotelgalaxy_navigation_search' ) ) {

	add_action( 'hotelgalaxy_inside_navigation_search', 'hotelgalaxy_navigation_search' );
	
	function hotelgalaxy_navigation_search() {
		
		if ( hotelgalaxy_get_option('is_menubar_search_icon') == false ) {
			return;
		}

		echo apply_filters( 'hotelgalaxy_navigation_search_output', sprintf('<div id="header_search" class="collapse header_search_box"> <span class="search_overlay" data-toggle="collapse" data-target="#header_search"> </span>   <form method="get" class="search-form hg-navigation-search" action="%1$s"> <input type="search" class="search-field" value="%2$s" name="s" title="%3$s"/> <button type="submit" class="search_box-search_btn" aria-label="%2$s"><i class="fa fa-search" aria-hidden="true"></i></a> </form> </div>',
			esc_url( home_url( '/' ) ),
			esc_attr( get_search_query() ),
			esc_attr_x( 'Search', 'label', 'hotel-galaxy' )
		));
	}
}

if(!function_exists('hotelgalaxy_get_rating')){

	add_action('hotelgalaxy_add_rating','hotelgalaxy_get_rating');

	function hotelgalaxy_get_rating( $data ){

		if( $data['is_rating'] != '' && isset( $data['rating'] )){			

			echo '<span class="hg_rating">';			

			for( $i=0; $i < 5; $i++){
				
				if( ( $data['rating'] - $i ) > 0 ){

					$class_active='active_rating ' . ( $data['rating']-$i );

				}else{

					$class_active = '';
				}

				echo sprintf('<i class="fa fa-star %1$s"></i>', esc_attr($class_active));
			}

			echo "</span>";
		}
	}

}


add_action( 'wp_ajax_hotelgalaxy_dismissed_notice_handler', 'hotelgalaxy_ajax_notice_handler' );


function hotelgalaxy_ajax_notice_handler() {

	if ( isset( $_POST['type'] ) ) {

		$type = sanitize_text_field( wp_unslash( $_POST['type'] ) );

		update_option( 'dismissed-' . $type, TRUE );
	}
}

add_action( 'admin_notices', 'hotelgalaxy_deprecated_hook_admin_notice' );

function hotelgalaxy_deprecated_hook_admin_notice(){

	if ( ! get_option('dismissed-get_started', FALSE ) ) {
		?>
		<div class="updated notice notice-get-started-class is-dismissible" data-notice="get_started">
			<div class="hotelgalaxy-getting-started-notice clearfix">
				<div class="hotelgalaxy-theme-screenshot">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/screenshot.png" class="screenshot" alt="<?php esc_attr_e( 'Theme Screenshot', 'hotel-galaxy' ); ?>" />
				</div>
				<div class="hotelgalaxy-theme-notice-content">
					<h2 class="hotelgalaxy-notice-h2">
						<?php
						printf(            					
							esc_html__( 'Thank you for choosing %1$s', 'hotel-galaxy' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
							?>
						</h2>

						<p class="plugin-install-notice"><?php echo sprintf(__('Install and activate <strong>Webdzier Companion</strong> plugin and get all the features this theme.', 'hotel-galaxy')) ?></p>

						<a class="hotelgalaxy-btn-get-started button button-primary button-hero hotelgalaxy-button-padding" href="#" data-name="" data-slug=""><?php esc_html_e( 'Get started with Hotel Galaxy', 'hotel-galaxy' ) ?></a><span class="hotelgalaxy-push-down">
							<?php

							printf(
								'or %1$sCustomize theme%2$s</a></span>',
								'<a target="_blank" href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
								'</a>'
							);
							?>
						</div><!-- end -->
					</div>
				</div>
			<?php }

		}



		add_action( 'wp_ajax_install_act_plugin', 'hotelgalaxy_admin_install_plugin' );

		function hotelgalaxy_admin_install_plugin() {

			include_once ABSPATH . '/wp-admin/includes/file.php';
			include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			if ( ! file_exists( WP_PLUGIN_DIR . '/webdzier-companion' ) ) {
				$api = plugins_api( 'plugin_information', array(
					'slug'   => sanitize_key( wp_unslash( 'webdzier-companion' ) ),
					'fields' => array(
						'sections' => false,
					),
				) );

				$skin     = new WP_Ajax_Upgrader_Skin();
				$upgrader = new Plugin_Upgrader( $skin );
				$result   = $upgrader->install( $api->download_link );
			}

    // Activate plugin.
			if ( current_user_can( 'activate_plugin' ) ) {
				$result = activate_plugin( 'webdzier-companion/webdzier-companion.php' );
			}
		}	

		?>