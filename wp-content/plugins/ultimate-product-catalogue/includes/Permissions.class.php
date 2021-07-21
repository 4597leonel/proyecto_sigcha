<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'ewdupcpPermissions' ) ) {
/**
 * Class to handle plugin permissions for Ultimate Product Catalog
 *
 * @since 5.0.0
 */
class ewdupcpPermissions {

	private $plugin_permissions;
	private $permission_level;

	public function __construct() {

		$this->plugin_permissions = array(
			'styling' 			=> 2,
			'premium' 			=> 2,
			'custom_fields'		=> 2,
			'product_page'		=> 2,
			'woocommerce'		=> 2,
			'seo'				=> 2,
			'import'			=> 2,
			'export'			=> 2,
			'labelling'			=> 2,
		);
	}

	public function set_permissions() {
		global $ewd_upcp_controller;

		if ( get_option( 'ewd-upcp-permission-level' ) >= 2 ) { return; }

		$this->permission_level = get_option( 'EWD_UPCP_Full_Version' ) == 'Yes' ? 2 : 1;

		update_option( 'ewd-upcp-permission-level', $this->permission_level );
	}

	public function get_permission_level() {

		$this->permission_level = get_option( 'ewd-upcp-permission-level' );

		if ( ! $this->permission_level ) { $this->set_permissions(); }
	}

	public function check_permission( $permission_type = '' ) {

		if ( ! $this->permission_level ) { $this->get_permission_level(); }
		
		return ( array_key_exists( $permission_type, $this->plugin_permissions ) ? ( $this->permission_level >= $this->plugin_permissions[$permission_type] ? true : false ) : false );
	}

	public function update_permissions() {

		$this->permission_level = get_option( 'ewd-upcp-permission-level' );
	}
}

}