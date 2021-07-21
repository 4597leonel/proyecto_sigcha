<?php

class Hotelgalaxy_Customize_Pro {	
	
	public function __construct() {

		add_action( 'customize_register', array( $this, 'my_sections' ) );
		
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}
	
	public function my_sections( $manager ) {
		
		require_once get_template_directory() . '/inc/customizer/pro-customizer/pro-section.php';

		$manager->register_section_type( 'Hotelgalaxy_Customize_Section_Pro' );
		
		$manager->add_section(
			new Hotelgalaxy_Customize_Section_Pro(
				$manager,
				'hotelgalaxy',
				array(
					
					'pro_text' => esc_html__( 'Get More Features','hotel-galaxy' ),
					'pro_url'  => 'webdzier.com/hotel-galaxy-premium/',
					'priority' => 0
				)
			)
		);
	}

	
	public function enqueue_control_scripts() { 

		wp_enqueue_script( 'hotelgalaxy-pro-customize-control', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/pro-customizer/pro-customize-control.js', array( 'customize-controls' ) );    

		wp_enqueue_style( 'hotelgalaxy-pro-customize-control', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/pro-customizer/pro-customize-control.css' );
	}
}

new Hotelgalaxy_Customize_Pro();