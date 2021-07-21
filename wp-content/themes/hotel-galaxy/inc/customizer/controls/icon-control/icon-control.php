<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'WP_Customize_Control' ) )  return null;

class Hotelgalaxy_Icon_Picker_Control extends WP_Customize_Control{

	private $icons = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {

		$icon_list = Hotelgalaxy_get_icons();

		ksort( $icon_list );

		$this->icons = $icon_list;

		parent::__construct( $manager, $id, $args );
	}

	public function enqueue() {

		wp_enqueue_style('hg-font-awesome', get_template_directory_uri().'/assets/css/fontawesome.css', array(), HotelGalaxy_Version );

		$css = '.customize-control select.icons{width: 100%; font: normal normal normal 14px/1 FontAwesome;}';
	}	


	public function render_content() {
		if ( ! empty( $this->icons ) ) { ?>
			<label>
				<span class="customize-control-title" style="flex: 2 0 0; vertical-align: middle;"><?php echo esc_html( $this->label ); ?></span>
				<select class="icons" <?php $this->link(); ?> style="font-family: 'FontAwesome', Arial;">
					<?php
					foreach ( $this->icons as $k=>$v ) {
						printf('<option value="%s" %s>%s</option>', $k, selected($this->value(), $k, false), $v);
					}
					?>
				</select>
			</label>
		<?php }
	}


	
}