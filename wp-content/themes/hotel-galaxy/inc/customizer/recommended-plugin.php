<?php
/* Plugin Notification in customizer */

require trailingslashit( dirname( __FILE__ ) ) . 'customizer-notify/hotel-notify.php';

$hotel_config_customizer = array(
	'recommended_plugins'       => array(
		'webdzier-companion' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>Webdzier Companion</strong> plugin for taking full advantage of all the features this theme has to offer Hotel Galaxy.', 'hotel-galaxy')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'hotel-galaxy' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'hotel-galaxy' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'hotel-galaxy' ),
	'activate_button_label'     => esc_html__( 'Activate', 'hotel-galaxy' ),
	'hotelgalaxy_deactivate_button_label'   => esc_html__( 'Deactivate', 'hotel-galaxy' ),
);
HotelGalaxy_Customizer_Notify::init( apply_filters( 'hotelgalaxy_customizer_notify_array', $hotel_config_customizer ) );
