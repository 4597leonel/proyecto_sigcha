<?php

/*
Plugin Name: Ultimate Product Catalog - WordPress Catalog Plugin
Plugin URI: http://www.EtoileWebDesign.com/plugins/ultimate-product-catalog/
Description: Product catalog plugin that is responsive and designed to display your products in a sleek and easy to customize catalog format.
Author: Etoile Web Design
Author URI: http://www.EtoileWebDesign.com/plugins/ultimate-product-catalog/
Terms and Conditions: http://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: ultimate-product-catalogue
Version: 4.5.1
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( function_exists( 'activate_plugin' ) and function_exists( 'deactivate_plugins' ) ) {

	activate_plugin( 'ultimate-product-catalogue/ultimate-product-catalogue.php' );

	deactivate_plugins( 'ultimate-product-catalogue/UPCP_Main.php' );
}

?>