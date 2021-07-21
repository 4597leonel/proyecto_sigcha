<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ewdupcpBlocks' ) ) {
/**
 * Class to handle plugin Gutenberg blocks
 *
 * @since 5.0.0
 */
class ewdupcpBlocks {

	public function __construct() {

		add_action( 'init', array( $this, 'add_blocks' ) );
		
		add_filter( 'block_categories', array( $this, 'add_block_category' ) );
	}

	/**
	 * Add the Gutenberg block to the list of available blocks
	 * @since 5.0.0
	 */
	public function add_blocks() {

		if ( ! function_exists( 'render_block_core_block' ) ) { return; }

		$this->enqueue_assets();   

		$args = array(
			'attributes' 	=> array(
				'id' 				=> array(
					'type' => 'string',
				),
				'sidebar' 			=> array(
					'type' => 'string',
				),
				'starting_layout' 	=> array(
					'type' => 'string',
				),
				'excluded_layouts' 	=> array(
					'type' => 'string',
				),
			),
			'editor_script'   	=> 'ewd-upcp-blocks-js',
			'editor_style'  	=> 'ewd-upcp-blocks-css',
			'render_callback' 	=> 'ewd_upcp_tracking_form_shortcode',
		);

		register_block_type( 'ultimate-product-catalogue/ewd-upcp-display-catalog-block', $args );
	}

	/**
	 * Create a new category of blocks to hold our block
	 * @since 5.0.0
	 */
	public function add_block_category( $categories ) {
		
		$categories[] = array(
			'slug'  => 'ewd-upcp-blocks',
			'title' => __( 'Ultimate Product Catalog', 'ultimate-product-catalogue' ),
		);

		return $categories;
	}

	/**
	 * Register the necessary JS and CSS to display the block in the editor
	 * @since 5.0.0
	 */
	public function enqueue_assets() {

		wp_register_script( 'ewd-upcp-blocks-js', EWD_UPCP_PLUGIN_URL . '/assets/js/ewd-upcp-blocks.js', array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ), EWD_UPCP_VERSION );
		wp_register_style( 'ewd-upcp-blocks-css', EWD_UPCP_PLUGIN_URL . '/assets/css/ewd-upcp-blocks.css', array( 'wp-edit-blocks' ), EWD_UPCP_VERSION );
	}
}

}