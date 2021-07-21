<?php

class Hotelgalaxy_Customize_Section_Pro extends WP_Customize_Section {	
	
	public $type = 'hotelgalaxy';
	
	public $pro_text = '';
	
	public $pro_url = '';

	
	public function json() {
		$json = parent::json();

		$json['pro_text'] = $this->pro_text;
		$json['pro_url']  = esc_url( $this->pro_url );

		return $json;
	}	
	protected function render_template() { ?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand control-section-default" aria-owns="sub-accordion-section-hotelgalaxy-pro">
			<h3 class="accordion-section-title">
				{{ data.title }}
				<a href="{{ data.pro_url }}" class="wp-ui-text-highlight" target="_blank" rel="noopener">{{ data.pro_text }}</a>
			</h3>
		</li>
		<?php
	}
}