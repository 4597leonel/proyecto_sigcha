<?php 

if ( ! defined( 'ABSPATH' ) ) {	exit; }

if ( ! function_exists( 'hotelgalaxy_navigation_position' ) ) {

	add_action('hotelgalaxy_menu', 'hotelgalaxy_navigation_position');
	
	function hotelgalaxy_navigation_position() {		

		?>
		<div class="navbar-header">			
			<?php do_action( 'hg_inside_mobile_header' ); ?>
			<div class="header_right_area">
				<?php do_action( 'hotelgalaxy_menu_search' ) ?>
				<button type="button" id="hg-mobile-menu-button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only"><?php esc_html_e('Toggle navigation','hotel-galaxy'); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>	
			</div>
		</div>
		
		<nav class="navbar navbar-default main-navigation">
			<div class="collapse navbar-collapse" id="navbar">
				<?php 

				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class' => 'nav navbar-nav',
					'fallback_cb' => 'hotelgalaxy_wp_bootstrap_navwalker::fallback',	
					'walker' => new hotelgalaxy_wp_bootstrap_navwalker()						
				));							

				?> 	
			</div>

			<?php do_action( 'hotelgalaxy_inside_navigation_search' )	?> 	
		</nav>

		<?php
	}

}


if ( ! function_exists( 'hotelgalaxy_header_items' ) ) {

	add_action('hotelgalaxy_add_logo', 'hotelgalaxy_header_items');

	function hotelgalaxy_header_items() {

		$order = apply_filters( 'hotelgalaxy_header_items_order',
			array(
				'site-title',
				'logo',
			)
		);		

		foreach ( $order as $item ) {

			if ( 'site-title' === $item ) {
				hotelgalaxy_site_title_construct();
			}

			if ( 'logo' === $item ) {
				hotelgalaxy_logo_construct();
			}
		}

	}
}


if ( ! function_exists( 'hotelgalaxy_site_title_construct' ) ) {

	function hotelgalaxy_site_title_construct() {
		
		$title = get_bloginfo( 'title' );
		$tagline = get_bloginfo( 'description' );

		$site_title = apply_filters( 'hotelgalaxy_site_title_output', sprintf(
			'<%1$s class="main-title" itemprop="headline">
			<a href="%2$s" rel="home">
			%3$s
			</a>
			</%1$s>',

			( is_front_page() && is_home() ) ? 'h1' : 'p',

			esc_url( apply_filters( 'hotelgalaxy_site_title_href', home_url( '/' ) ) ),

			get_bloginfo( 'name' )

		) );

		$site_tagline = apply_filters( 'hotelgalaxy_site_description_output', sprintf(
			'<p class="site-description" itemprop="description">
			%1$s
			</p>',
			html_entity_decode( get_bloginfo( 'description', 'display' ) )
		) );

		$show_title = hotelgalaxy_get_option('show_title');


		$show_tagline = hotelgalaxy_get_option('show_tagline');

			// ***

		if ( $show_title || $show_tagline ) {			

			echo apply_filters( 'hotelgalaxy_site_branding_output', sprintf( 
				'<div class="site-branding">
				%1$s
				%2$s
				</div>',
				( $show_title ) ? $site_title : '',
				( $show_tagline ) ? $site_tagline : ''
			) );

		}
	}
}


if ( ! function_exists( 'hotelgalaxy_logo_construct' ) ) {

	function hotelgalaxy_logo_construct() {

		$logo = ( function_exists( 'the_custom_logo' ) && get_theme_mod( 'custom_logo' ) ) ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ) : false;

		$logo_url = (is_array($logo)) ? $logo[0] : '';


		if ( empty( $logo_url ) ) {
			return;
		}

		$attr = apply_filters( 'hotelgalaxy_logo_attributes', array(
			'class' => 'header-image',

			'alt'	=> esc_attr( apply_filters( 'hotelgalaxy_logo_title', get_bloginfo( 'name', 'display' ) ) ),

			'src'	=> $logo_url,

			'title'	=> esc_attr( apply_filters( 'hotelgalaxy_logo_title', get_bloginfo( 'name', 'display' ) ) ),
		) );

		$attr = array_map( 'esc_attr', $attr );

		$html_attr = '';
		foreach ( $attr as $name => $value ) {
			$html_attr .= " $name=" . '"' . $value . '"';
		}

		echo apply_filters( 'hotelgalaxy_logo_output', sprintf( 
			'<div class="site-logo">
			<a href="%1$s" title="%2$s" rel="home">
			<img %3$s />
			</a>
			</div>',
			esc_url( apply_filters( 'hotelgalaxy_logo_href' , home_url( '/' ) ) ),
			esc_attr( apply_filters( 'hotelgalaxy_logo_title', get_bloginfo( 'name', 'display' ) ) ),
			$html_attr
		), $logo_url, $html_attr );

	}

}



if ( ! function_exists( 'hotelgalaxy_get_before_header' ) ) {

	add_action( 'hotelgalaxy_before_header', 'hotelgalaxy_get_before_header' );

	function hotelgalaxy_get_before_header() {

		$headers = array('transparent','standard','classic');		

		if( in_array( hotelgalaxy_get_option( 'header_layout' ), $headers ) ){

			do_action('hotelgalaxy_site_info_bar');
		}		
	}
}


if ( ! function_exists( 'hotelgalaxy_get_after_header' ) ) {

	add_action( 'hotelgalaxy_after_header', 'hotelgalaxy_get_after_header' );

	function hotelgalaxy_get_after_header() {

		if( 'default' == hotelgalaxy_get_option('header_layout')){
			do_action('hotelgalaxy_site_info_bar');
		}		
	}
}


if ( ! function_exists( 'hotelgalaxy_site_info_bar_position' ) ) {

	add_action('hotelgalaxy_site_info_bar', 'hotelgalaxy_site_info_bar_position');
	
	function hotelgalaxy_site_info_bar_position() {		

		$hotelgalaxy_settings = hotelgalaxy_option();

		if( $hotelgalaxy_settings['is_information_bar'] != true){ 
			return false;
		}

		?>

		<div class="info-bar wow fadeInUp">
			<div class="container d-flex content-center">
				<div class="info-bar-left">
					<?php if(!empty($hotelgalaxy_settings['information_text_1'])){ ?>

						<span id="info-1" class="info-bar-inner user-addr" >

							<?php 

							echo sprintf( '<span><i class="fa %1$s"></i>&nbsp; </span> %2$s', 
								esc_attr( $hotelgalaxy_settings['information_title_1'] ), 
								esc_html( $hotelgalaxy_settings['information_text_1'] )  
							);

							?>						
							
						</span>

					<?php } ?>


					<?php if(!empty($hotelgalaxy_settings['information_text_2'])){ ?>
						<span id="info-2" class="info-bar-inner" >

							<?php 

							echo sprintf( '<span><i class="fa %1$s"></i> &nbsp;</span> %2$s',
								esc_attr( $hotelgalaxy_settings['information_title_2'] ),  
								esc_html( $hotelgalaxy_settings['information_text_2'])  
							);

							?>

						</span>
					<?php } ?>
				</div>
				<div class="info-bar-right">
					<span class="info-bar-inner user-social">

						<?php 

						for( $i=1; $i<=5; $i++ ){	

							$socialmedia_icon = !empty($hotelgalaxy_settings['socialmedia_icon_'.$i]) ? $hotelgalaxy_settings['socialmedia_icon_'.$i] : '';

							$socialmedia_url = !empty($hotelgalaxy_settings['socialmedia_url_'.$i]) ? $hotelgalaxy_settings['socialmedia_url_'.$i] : ''; 

							if( !empty( $socialmedia_icon ) && !empty( $socialmedia_url ) ){ 

								echo sprintf( 
									'<a href="%1$s" id="bar-social-icon-%3$s" target="_blank" class="social-icon" data-toggle="tooltip"><i class="fa %2$s"></i></a>', 

									esc_url( $socialmedia_url ),

									esc_html( $socialmedia_icon ),

									esc_attr( $i ) 
								);
							}
						}					
						
						?>

					</span>

				</div>
			</div>
		</div>

		<?php
	}
}
?>