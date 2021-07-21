<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ewdupcpSettings' ) ) {
/**
 * Class to handle configurable settings for Ultimate Product Catalog
 * @since 5.0.0
 */
class ewdupcpSettings {

	/**
	 * Default values for settings
	 * @since 5.0.0
	 */
	public $defaults = array();

	public $email_options = array();

	/**
	 * Stored values for settings
	 * @since 5.0.0
	 */
	public $settings = array();

	public function __construct() {

		add_action( 'init', array( $this, 'set_defaults' ) );

		add_action( 'init', array( $this, 'set_field_options' ) );

		add_action( 'init', array( $this, 'load_settings_panel' ) );

		if ( ! empty( $_POST['ewd-upcp-settings']['product-inquiry-form'] ) or ! empty( $_POST['ewd-upcp-settings']['product-inquiry-cart'] ) ) { 
			
			add_action( 'init', array( $this, 'create_product_inquiry_form' ), 11 );
		}

		if ( ! empty( $_POST['ewd-upcp-settings']['access-role'] ) ) { 
			
			add_action( 'init', array( $this, 'manage_user_capabilities' ), 11 );
		}
	}

	/**
	 * Load the plugin's default settings
	 * @since 5.0.0
	 */
	public function set_defaults() {

		$this->defaults = array(

			'currency-symbol-location'			=> 'before',
			'sale-mode'							=> 'individual',
			'color-scheme'						=> 'black',
			'sidebar-layout'					=> 'normal',
			'tag-logic'							=> 'or',
			'show-catalog-information'			=> array(),
			'overview-mode'						=> 'none',
			'access-role'						=> 'manage_options',
			'social-media-links'				=> array(),
			'display-category-image'			=> array(),
			'breadcrumbs'						=> array(),
			'extra-elements'					=> array(),

			'product-page'						=> 'default',
			'product-image-lightbox'			=> 'no',
			'related-products'					=> 'none',
			'next-previous-products'			=> 'none',
			'pagination-location'				=> 'top',
			'product-inquiry-plugin'			=> 'wpforms',
			'products-per-page'					=> 100,
			'product-search'					=> array(),

			'woocommerce-cart-page'				=> 'cart',

			'seo-plugin'						=> 'none',
			'seo-integration'					=> 'add',
			'seo-title'							=> '[page-title] | [product-name]',
			'permalink-base'					=> 'product',

			'label-back-to-catalog'				=> __( 'Back to Catalog', 'ultimate-product-catalogue' ),
			'label-updating-results'			=> __( 'Updating Results...', 'ultimate-product-catalogue' ),
			'label-no-results-found'			=> __( 'No Results Found', 'ultimate-product-catalogue' ),
			'label-compare'						=> __( 'Compare', 'ultimate-product-catalogue' ),
			'label-side-by-side'				=> __( 'side by side', 'ultimate-product-catalogue' ),

			'styling-catalog-skin'							=> 'default',
			'styling-category-heading-style'				=> 'normal',
			'styling-list-view-click-action'				=> 'product',
			'styling-sidebar-title-hover'					=> 'none',
			'styling-sidebar-checkbox-style'				=> 'none',
			'styling-sidebar-categories-control-type'		=> 'checkbox',
			'styling-sidebar-subcategories-control-type'	=> 'checkbox',
			'styling-sidebar-tags-control-type'				=> 'checkbox',

			'styling-sidebar-items-order'		=> json_encode( 
				array(
					'sort'							=> 'Sort By',
					'search'						=> 'Product Search',
					'price_filter'					=> 'Price Filtering',
					'categories'					=> 'Categories',
					'subcategories'					=> 'Sub-Categories',
					'tags'							=> 'Tags',
					'custom_fields'					=> 'Custom Fields',
				)
			),
		);

		$this->defaults = apply_filters( 'ewd_upcp_defaults', $this->defaults );
	}

	/**
	 * Put all of the available possible select options into key => value arrays
	 * @since 5.0.0
	 */
	public function set_field_options() {
		global $ewd_upcp_controller;


	}

	/**
	 * Get a setting's value or fallback to a default if one exists
	 * @since 5.0.0
	 */
	public function get_setting( $setting ) { 

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'ewd-upcp-settings' );
		}
		
		if ( ! empty( $this->settings[ $setting ] ) ) {
			return apply_filters( 'ewd-upcp-settings-' . $setting, $this->settings[ $setting ] );
		}

		if ( isset( $this->defaults[ $setting ] ) ) { 
			return apply_filters( 'ewd-upcp-settings-' . $setting, $this->defaults[ $setting ] );
		}

		return apply_filters( 'ewd-upcp-settings-' . $setting, null );
	}

	/**
	 * Set a setting to a particular value
	 * @since 5.0.0
	 */
	public function set_setting( $setting, $value ) {

		$this->settings[ $setting ] = $value;
	}

	/**
	 * Save all settings, to be used with set_setting
	 * @since 5.0.0
	 */
	public function save_settings() {
		
		update_option( 'ewd-upcp-settings', $this->settings );
	}

	/**
	 * Load the admin settings page
	 * @since 5.0.0
	 * @sa https://github.com/NateWr/simple-admin-pages
	 */
	public function load_settings_panel() {

		global $ewd_upcp_controller;

		require_once( EWD_UPCP_PLUGIN_DIR . '/lib/simple-admin-pages/simple-admin-pages.php' );
		$sap = sap_initialize_library(
			$args = array(
				'version'       => '2.5.3',
				'lib_url'       => EWD_UPCP_PLUGIN_URL . '/lib/simple-admin-pages/',
			)
		);
		
		$sap->add_page(
			'submenu',
			array(
				'id'            => 'ewd-upcp-settings',
				'title'         => __( 'Settings', 'ultimate-product-catalogue' ),
				'menu_title'    => __( 'Settings', 'ultimate-product-catalogue' ),
				'parent_menu'	=> 'edit.php?post_type=upcp_product',
				'description'   => '',
				'capability'    => $this->get_setting( 'access-role' ),
				'default_tab'   => 'ewd-upcp-basic-tab',
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-basic-tab',
				'title'         => __( 'Basic', 'ultimate-product-catalogue' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-general',
				'title'         => __( 'General', 'ultimate-product-catalogue' ),
				'tab'	        => 'ewd-upcp-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-general',
			'text',
			array(
				'id'            => 'currency-symbol',
				'title'         => __( 'Currency Symbol', 'ultimate-product-catalogue' ),
				'description'	=> __( 'What currency symbol, if any, should be displayed before or after the price? Leave blank for none.', 'ultimate-product-catalogue' )
			),
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-general',
			'radio',
			array(
				'id'			=> 'currency-symbol-location',
				'title'			=> __( 'Currency Symbol Location', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the currency symbol, if selected, be displayed before or after the price?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'before'		=> __( 'Before', 'ultimate-product-catalogue' ),
					'after'			=> __( 'After', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['currency-symbol-location']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-general',
			'radio',
			array(
				'id'			=> 'sale-mode',
				'title'			=> __( 'Sale Mode', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should all products be put on sale (\'All\'), no products be on sale (\'None\'), or sale prices be shown only for selected products (\'Individual\')?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'all'			=> __( 'All', 'ultimate-product-catalogue' ),
					'individual'	=> __( 'Individual', 'ultimate-product-catalogue' ),
					'none'			=> __( 'None', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['sale-mode']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-general',
			'toggle',
			array(
				'id'			=> 'thumbnail-support',
				'title'			=> __( 'Thumbnail Support', 'ultimate-product-catalogue' ),
				'description'	=> __( 'If available, should thumbnail version of images be used on the main catalog pages?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-general',
			'toggle',
			array(
				'id'			=> 'maintain-filtering',
				'title'			=> __( 'Maintain Filtering', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should filtering be maintained when clicking the back button after viewing a product page? (May cause redirect issues if catalog is placed on homepage.)', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-general',
			'checkbox',
			array(
				'id'            => 'social-media-links',
				'title'         => __( 'Social Media Options', 'ultimate-product-catalogue' ),
				'description'   => __( 'Which social media links should be displayed on the product page?', 'ultimate-product-catalogue' ), 
				'options'       => array(
					'facebook'		=> __( 'Facebook', 'ultimate-product-catalogue' ),
					'twitter'		=> __( 'Twitter', 'ultimate-product-catalogue' ),
					'linkedin'		=> __( 'Linkedin', 'ultimate-product-catalogue' ),
					'pinterest'		=> __( 'Pinterest', 'ultimate-product-catalogue' ),
					'email'			=> __( 'Email', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-general',
			'select',
			array(
				'id'            => 'access-role',
				'title'         => __( 'Set Access Role', 'ultimate-product-catalogue' ),
				'description'   => __( 'Who should have access to the "Ultimate Product Catalog" admin menu? (Roles of contributor or higher will still be able to see the Products/Catalots/Categories/Tags menus, but will not be able to edit the items [similar to how it works for the default post types in WordPress]).', 'ultimate-product-catalogue' ), 
				'blank_option'	=> false,
				'options'       => array(
					'administrator'				=> __( 'Administrator', 'ultimate-product-catalogue' ),
					'delete_others_pages'		=> __( 'Editor', 'ultimate-product-catalogue' ),
					'delete_published_posts'	=> __( 'Author', 'ultimate-product-catalogue' ),
					'delete_posts'				=> __( 'Contributor', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-basic-catalog-page',
				'title'         => __( 'Catalog Page Display', 'ultimate-product-catalogue' ),
				'tab'	        => 'ewd-upcp-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'radio',
			array(
				'id'			=> 'color-scheme',
				'title'			=> __( 'Catalog Color', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Set the color of the image and border elements', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'blue'			=> __( 'Blue', 'ultimate-product-catalogue' ),
					'black'			=> __( 'Black', 'ultimate-product-catalogue' ),
					'grey'			=> __( 'Grey', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['color-scheme']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'toggle',
			array(
				'id'			=> 'disable-thumbnail-auto-adjust',
				'title'			=> __( 'Disable Auto-Adjust Thumbnail Heights', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the auto-adjust of the product thumbnails heights to the height of the longest product be disabled? This prevents lines with odd numbers of products, products not starting on the left, etc.', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'radio',
			array(
				'id'			=> 'sidebar-layout',
				'title'			=> __( 'Sub-Category Style', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should categories and sub-categories be arranged hierarchically or be grouped?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'normal'		=> __( 'Normal', 'ultimate-product-catalogue' ),
					'hierarchical'	=> __( 'Hierarchical', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['sidebar-layout']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'toggle',
			array(
				'id'			=> 'details-read-more',
				'title'			=> __( 'Read More', 'ultimate-product-catalogue' ),
				'description'	=> __( 'In the \'Details\' layout, should the product description be cutoff if it\'s long?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'text',
			array(
				'id'            => 'details-description-characters',
				'title'         => __( 'Characters in Details Description', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Set maximum number of characters in product description in the \'Details\' layout', 'ultimate-product-catalogue' )
			),
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'checkbox',
			array(
				'id'			=> 'show-catalog-information',
				'title'			=> __( 'Show Catalog Information', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the name or description of the catalog be shown above the catalog?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'name'			=> __( 'Name', 'ultimate-product-catalogue' ),
					'description'	=> __( 'Description', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'toggle',
			array(
				'id'			=> 'show-category-descriptions',
				'title'			=> __( 'Show Category Descriptions', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the descriptions of product categories be shown below them?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'checkbox',
			array(
				'id'			=> 'display-category-image',
				'title'			=> __( 'Display Category Image', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the category image be displayed on the main catalog page?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'sidebar'		=> __( 'Sidebar', 'ultimate-product-catalogue' ),
					'main'			=> __( 'Main', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'toggle',
			array(
				'id'			=> 'display-subcategory-image',
				'title'			=> __( 'Display Sub-Category Image', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the sub-category image be displayed in the sidebar on the main catalog page?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'toggle',
			array(
				'id'			=> 'display-categories-in-product-thumbnail',
				'title'			=> __( 'Display Categories in Thumbnails', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the category and sub-category associated with a product be displayed in the product listing on the catalog page?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-catalog-page',
			'toggle',
			array(
				'id'			=> 'display-tags-in-product-thumbnail',
				'title'			=> __( 'Display Tags in Thumbnails', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the tags associated with a product be displayed in the product listing on the catalog page?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-catalog-page-functionality',
				'title'         => __( 'Catalog Page Functionality', 'ultimate-product-catalogue' ),
				'tab'	        => 'ewd-upcp-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'toggle',
			array(
				'id'			=> 'product-links',
				'title'			=> __( 'Product Links', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should external product links open in a new window?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'radio',
			array(
				'id'			=> 'tag-logic',
				'title'			=> __( 'Tag Logic', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Gives users the option to use multiple tags at the same time in filtering (\'OR\' option)', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'and'			=> __( 'AND', 'ultimate-product-catalogue' ),
					'or'			=> __( 'OR', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['tag-logic']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'toggle',
			array(
				'id'			=> 'disable-price-filter',
				'title'			=> __( 'Disable Price Filtering', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should price filtering be hidden from the catalog sidebar?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'toggle',
			array(
				'id'			=> 'disable-slider-filter-text-inputs',
				'title'			=> __( 'Disable Slider Filter Text Inputs', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should slider filter text inputs be disabled, preventing users from adjusting the min/max values by text?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'radio',
			array(
				'id'			=> 'overview-mode',
				'title'			=> __( 'Catalog Overview Mode', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should visitors see an overview of the categories instead of all products when the page first loads?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'full'			=> __( 'Categories and Sub-Categories', 'ultimate-product-catalogue' ),
					'cats'			=> __( 'Categories Only', 'ultimate-product-catalogue' ),
					'none'			=> __( 'None', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['overview-mode']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'checkbox',
			array(
				'id'			=> 'product-search',
				'title'			=> __( 'Product Search', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Select which portions of a product should be searched when using the text search box? Custom fields search can take significantly longer to return results.', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'name'			=> __( 'Name', 'ultimate-product-catalogue' ),
					'description'	=> __( 'Description', 'ultimate-product-catalogue' ),
					'custom_fields'	=> __( 'Custom Fields', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'toggle',
			array(
				'id'			=> 'clear-all-filtering',
				'title'			=> __( '\'Clear All\' Option', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should an option be added to the top of sidebar to clear all filtering options?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-catalog-page-functionality',
			'toggle',
			array(
				'id'			=> 'hide-empty-options-filtering',
				'title'			=> __( 'Hide Empty Filtering Options', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should filtering options that would no longer display any results be hidden?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-basic-product-page',
				'title'         => __( 'Product Page', 'ultimate-product-catalogue' ),
				'tab'	        => 'ewd-upcp-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-product-page',
			'checkbox',
			array(
				'id'			=> 'breadcrumbs',
				'title'			=> __( 'Breadcrumbs', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Which breadcrumbs, if any, should display on the product page?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'catalog'		=> __( 'Catalog', 'ultimate-product-catalogue' ),
					'categories'	=> __( 'Categories', 'ultimate-product-catalogue' ),
					'subcategories'	=> __( 'Sub-Categories', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-product-page',
			'checkbox',
			array(
				'id'			=> 'extra-elements',
				'title'			=> __( 'Extra Elements', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Select elements to be displayed on each product page.', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'category'		=> __( 'Category Name(s)', 'ultimate-product-catalogue' ),
					'subcategory'	=> __( 'Sub-Category Name(s)', 'ultimate-product-catalogue' ),
					'tags'			=> __( 'Tags', 'ultimate-product-catalogue' ),
					'customfields'	=> __( 'Custom Fields', 'ultimate-product-catalogue' ),
					'videos'		=> __( 'Videos', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-basic-product-page',
			'toggle',
			array(
				'id'			=> 'disable-product-page-price',
				'title'			=> __( 'Disable Product Page Price', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should a product\'s price be hidden on the product pages?', 'ultimate-product-catalogue' )
			)
		);

		if ( ! $ewd_upcp_controller->permissions->check_permission( 'premium' ) ) {
			$ewd_upcp_premium_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $ewd_upcp_premium_permissions = array(); }

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-premium-tab',
				'title'         => __( 'Premium', 'ultimate-product-catalogue' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-premium-product-page',
					'title'         => __( 'Product Page', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-premium-tab',
				),
				$ewd_upcp_premium_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-product-page',
			'radio',
			array(
				'id'			=> 'product-page',
				'title'			=> __( 'Product Page Type', 'ultimate-product-catalogue' ),
				'description'	=> __( 'What style of product page should be used?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'default'		=> __( 'Default', 'ultimate-product-catalogue' ),
					'tabbed'		=> __( 'Tabbed', 'ultimate-product-catalogue' ),
					'shop_style'	=> __( 'Shop Style', 'ultimate-product-catalogue' ),
					'custom'		=> __( 'Custom', 'ultimate-product-catalogue' ),
					'large'			=> __( 'Custom - Large Screen Only', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['product-page']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-product-page',
			'radio',
			array(
				'id'			=> 'product-image-lightbox',
				'title'			=> __( 'Lightbox', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should a lightbox pop-up on the product page when an image is clicked? Want to customize this lightbox? Install the <a href=\'https://wordpress.org/plugins/ultimate-lightbox/\' target=\'_blank\'>Ultimate Lightbox</a> plugin and you can switch the lightbox colors, controls, behaviour and more!', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'yes'			=> __( 'Yes', 'ultimate-product-catalogue' ),
					'main'			=> __( 'Main Image Only', 'ultimate-product-catalogue' ),
					'no'			=> __( 'No', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['product-image-lightbox']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-product-page',
			'radio',
			array(
				'id'			=> 'related-products',
				'title'			=> __( 'Related Products', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should related products be created automatically, manually, or not at all?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'automatic'		=> __( 'Automatic', 'ultimate-product-catalogue' ),
					'manual'		=> __( 'Manual', 'ultimate-product-catalogue' ),
					'none'			=> __( 'None', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['related-products']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-product-page',
			'radio',
			array(
				'id'			=> 'next-previous-products',
				'title'			=> __( 'Next/Previous Products', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should next and previous products be displayed? Automatic takes the products with the next and previous IDs, if they exist.', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'automatic'		=> __( 'Automatic', 'ultimate-product-catalogue' ),
					'manual'		=> __( 'Manual', 'ultimate-product-catalogue' ),
					'none'			=> __( 'None', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['next-previous-products']
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-premium-catalog-page',
					'title'         => __( 'Catalog Page', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-premium-tab',
				),
				$ewd_upcp_premium_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-catalog-page',
			'toggle',
			array(
				'id'			=> 'lightbox-mode',
				'title'			=> __( 'Lightbox Mode', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should a lightbox pop-up to display more information about products when they\'re clicked on?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-catalog-page',
			'toggle',
			array(
				'id'			=> 'infinite-scroll',
				'title'			=> __( 'Infinite Scroll', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should products load as a user scrolls down the page, instead of using the pagination system?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-catalog-page',
			'text',
			array(
				'id'            => 'products-per-page',
				'title'         => __( 'Products per Page', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Set the maximum number of products per page for your catalogs', 'ultimate-product-catalogue' )
			),
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-catalog-page',
			'radio',
			array(
				'id'			=> 'pagination-location',
				'title'			=> __( 'Pagination Location', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Set the location of pagination controls for your catalogs', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'top'			=> __( 'Top', 'ultimate-product-catalogue' ),
					'bottom'		=> __( 'Bottom', 'ultimate-product-catalogue' ),
					'both'			=> __( 'Both', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['pagination-location']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-catalog-page',
			'checkbox',
			array(
				'id'			=> 'product-sort',
				'title'			=> __( 'Product Sorting', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Select which sorting options are available in the \'Sort By\' box (\'Review Rating\' requires \'Ultimate Reviews\' to be installed)', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'price'			=> __( 'Price', 'ultimate-product-catalogue' ),
					'name'			=> __( 'Name', 'ultimate-product-catalogue' ),
					'rating'		=> __( 'Review Ratings', 'ultimate-product-catalogue' ),
					'date'			=> __( 'Date Added', 'ultimate-product-catalogue' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-catalog-page',
			'toggle',
			array(
				'id'			=> 'disable-toggle-sidebar-on-mobile',
				'title'			=> __( 'Disable Drop Down Sidebar Toggle on Mobile', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Disable the \'Filter\' button, on mobile devices, that will display allowing the user to open the sidebar, with the sidebar hidden by default.', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-premium-features',
					'title'         => __( 'Features', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-premium-tab',
				),
				$ewd_upcp_premium_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'product-inquiry-form',
				'title'			=> __( 'Product Inquiry Form', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should a form be added to inquire about products on the product page (requires plugin \'WP Forms\' or \'Contact Form 7\')?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'product-inquiry-cart',
				'title'			=> __( 'Product Inquiry Cart', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should users be able to inquire about multiple products at once from the main catalog page (requires plugin \'WP Forms\' or \'Contact Form 7\')?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'radio',
			array(
				'id'			=> 'product-inquiry-plugin',
				'title'			=> __( 'Inquiry Plugin', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Which contact form plugin should be used?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'cf7'			=> __( 'Contact Form 7', 'ultimate-product-catalogue' ),
					'wpforms'		=> __( 'WP Forms', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['product-inquiry-plugin']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'product-reviews',
				'title'			=> __( 'Product Reviews', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should reviews be displayed for products on the \'Tabbed Layout\' product page (requires plugin \'Ultimate Reviews\')?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'catalog-display-reviews',
				'title'			=> __( 'Reviews in Main Catalog', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should a product\'s review rating be displayed on the main catalog page? (requires plugin \'<a href=\'https://wordpress.org/plugins/ultimate-reviews/\'>Ultimate Reviews</a>\')?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'product-faqs',
				'title'			=> __( 'Product FAQs', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should FAQs be displayed for products on the Tabbed or Shop Style layout product page (requires Ultimate FAQs plugin)?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'product-comparison',
				'title'			=> __( 'Allow Product Comparison', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should visitors be able to compare products side by side by clicking on the comparison link?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'hide-blank-custom-fields',
				'title'			=> __( 'Hide Blank Custom Fields', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should custom fields be hidden when they are empty?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-premium-features',
			'toggle',
			array(
				'id'			=> 'disable-custom-field-conversion',
				'title'			=> __( 'Disable Custom Slugs Conversion', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should converting of custom field slugs used in the product descriptions be disabled?', 'ultimate-product-catalogue' )
			)
		);

		if ( ! $ewd_upcp_controller->permissions->check_permission( 'woocommerce' ) ) {
			$ewd_upcp_woocommerce_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $ewd_upcp_woocommerce_permissions = array(); }

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-woocommerce-tab',
				'title'         => __( 'WooCommerce', 'ultimate-product-catalogue' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-woocommerce',
					'title'         => __( 'Settings', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-woocommerce-tab',
				),
				$ewd_upcp_woocommerce_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-woocommerce',
			'toggle',
			array(
				'id'			=> 'woocommerce-sync',
				'title'			=> __( 'WooCommerce Sync', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should UPCP products be exported to WooCommerce, and WooCommerce products imported into UPCP? Products edited in one plugin will also be edited in the other while this is enabled. Using WooCommerce attributes or UPCP custom fields and want those to sync as well? Check out our blog post on how to <a href=\'http://www.etoilewebdesign.com/product-catalog-woocommerce-sync-tips/\'>get the best syncing results for attributes</a>.', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-woocommerce',
			'toggle',
			array(
				'id'			=> 'woocommerce-disable-cart-count',
				'title'			=> __( 'Disable Cart Item Count', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the number of items in a visitors shopping cart be hidden?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-woocommerce',
			'toggle',
			array(
				'id'			=> 'woocommerce-checkout',
				'title'			=> __( 'WooCommerce Checkout', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should checkout be allowed, using the standard WooCommerce checkout? WARNING: WooCommerce sync must be enabled.', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-woocommerce',
			'radio',
			array(
				'id'			=> 'woocommerce-cart-page',
				'title'			=> __( 'WooCommerce Cart Page', 'ultimate-product-catalogue' ),
				'description'	=> __( 'What WooCommerce page should visitors be sent to when they click the \'Checkout\' cart button? WARNING: WooCommerce sync must be enabled.', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'cart'			=> __( 'Cart', 'ultimate-product-catalogue' ),
					'checkout'		=> __( 'Checkout', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['woocommerce-cart-page']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-woocommerce',
			'toggle',
			array(
				'id'			=> 'woocommerce-product-page',
				'title'			=> __( 'WooCommerce Product Page', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should visitors be redirected to WooCommerce product pages instead of UPCP product pages when clicking on a product? <br/>Having trouble with this setting? Try changing the \'Permalink Base\' setting in the \'SEO\' tab. WARNING: WooCommerce sync must be enabled.', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-woocommerce',
			'toggle',
			array(
				'id'			=> 'woocommerce-back-link',
				'title'			=> __( 'WooCommerce Back Link', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the WooCommerce product page breadcrumbs be replaced with a \'Back to Catalog\' link when coming directly from the catalog page?', 'ultimate-product-catalogue' )
			)
		);

		if ( ! $ewd_upcp_controller->permissions->check_permission( 'seo' ) ) { 
			$ewd_upcp_seo_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $ewd_upcp_seo_permissions = array(); }

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-seo-tab',
				'title'         => __( 'SEO', 'ultimate-product-catalogue' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-seo',
					'title'         => __( 'SEO Options', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-seo-tab',
				),
				$ewd_upcp_seo_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-seo',
			'toggle',
			array(
				'id'			=> 'pretty-permalinks',
				'title'			=> __( 'Pretty Permalinks', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should the plugin create SEO-friendly product page URLs? (Make sure product slugs have been filled in)', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-seo',
			'text',
			array(
				'id'            => 'permalink-base',
				'title'         => __( 'Permalink Base', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Set the permalink base for your product pages, if you want something other than \'product\' as a permalink base. You may need to re-save your permalink structure for this to take effect.', 'ultimate-product-catalogue' )
			),
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-seo',
			'radio',
			array(
				'id'			=> 'seo-plugin',
				'title'			=> __( 'SEO By Yoast Integration', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should descriptions and titles for product pages be added using Yoast?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'yoast'			=> __( 'Yes', 'ultimate-product-catalogue' ),
					'none'			=> __( 'No', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['seo-plugin']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-seo',
			'radio',
			array(
				'id'			=> 'seo-integration',
				'title'			=> __( 'Description Handling', 'ultimate-product-catalogue' ),
				'description'	=> __( 'If using Yoast, should the page description be added to or replaced?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'add'			=> __( 'Add', 'ultimate-product-catalogue' ),
					'replace'		=> __( 'Replace', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['seo-integration']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-seo',
			'text',
			array(
				'id'            => 'seo-title',
				'title'         => __( 'SEO Title', 'ultimate-product-catalogue' ),
				'description'	=> __( 'What should the page title be set to? Can use [page-title], [product-name], [category-name], [subcategory_name] to substitute those in the title.', 'ultimate-product-catalogue' )
			),
		);

		if ( ! $ewd_upcp_controller->permissions->check_permission( 'labelling' ) ) { 
			$ewd_upcp_labelling_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $ewd_upcp_labelling_permissions = array(); }

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-labelling-tab',
				'title'         => __( 'Labelling', 'ultimate-product-catalogue' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-labelling-sidebar',
					'title'         => __( 'Sidebar', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-labelling-tab',
				),
				$ewd_upcp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-categories',
				'title'         => __( 'Categories Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-subcategories',
				'title'         => __( 'Sub-Categories Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-tags',
				'title'         => __( 'Tags Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-show-all',
				'title'         => __( 'Clear All Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-sort-by',
				'title'         => __( 'Sort By Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-price-ascending',
				'title'         => __( 'Price (Ascending) Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-price-descending',
				'title'         => __( 'Price (Descending) Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-name-ascending',
				'title'         => __( 'Name (Ascending) Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-name-descending',
				'title'         => __( 'Name (Descending) Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-product-name-search',
				'title'         => __( 'Product Search (Product Name) Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-product-name-text',
				'title'         => __( 'Search Placeholder Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-sidebar',
			'text',
			array(
				'id'            => 'label-price-filter',
				'title'         => __( 'Price Filter/Slider Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-labelling-catalog',
					'title'         => __( 'Catalog', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-labelling-tab',
				),
				$ewd_upcp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-updating-results',
				'title'         => __( 'Updating Results Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-no-results-found',
				'title'         => __( 'No Products Found Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-products-pagination',
				'title'         => __( 'Products Pagination Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-page',
				'title'         => __( '\'Page\' Pagination Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-pagination-of',
				'title'         => __( '\'Of\' Pagination Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-read-more',
				'title'         => __( 'Read More Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-compare',
				'title'         => __( 'Compare Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-side-by-side',
				'title'         => __( 'Side by side Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-sale',
				'title'         => __( 'Sale Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-inquire-button',
				'title'         => __( 'Inquire Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-add-to-cart-button',
				'title'         => __( 'Add to Cart Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-send-inquiry',
				'title'         => __( 'Send Inquiry! Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-checkout',
				'title'         => __( 'Checkout! Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-empty-cart',
				'title'         => __( 'Empty cart Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-catalog',
			'text',
			array(
				'id'            => 'label-cart-items',
				'title'         => __( '\'%s items in cart\' Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-labelling-product-page',
					'title'         => __( 'Product Page', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-labelling-tab',
				),
				$ewd_upcp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-back-to-catalog',
				'title'         => __( 'Catalog Label (in breadcrumbs)', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-product-details-tab',
				'title'         => __( 'Product Details Tab Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-additional-info-tab',
				'title'         => __( 'Additional Information Tab Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-contact-form-tab',
				'title'         => __( 'Contact Us Tab Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-product-inquiry-form-title',
				'title'         => __( 'Product Inquiry Form Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-customer-reviews-tab',
				'title'         => __( 'Customer Reviews Tab Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-related-products',
				'title'         => __( 'Related Products Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-next-product',
				'title'         => __( 'Next Product Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-previous-product',
				'title'         => __( 'Previous Product Label', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-product-page-category',
				'title'         => __( 'Category Label (Product page)', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-product-page-subcategory',
				'title'         => __( 'Sub-category Label (Product page)', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-labelling-product-page',
			'text',
			array(
				'id'            => 'label-product-page-tags',
				'title'         => __( 'Tags Label (Product page)', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		if ( ! $ewd_upcp_controller->permissions->check_permission( 'styling' ) ) { 
			$ewd_upcp_styling_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $ewd_upcp_styling_permissions = array(); }

		$sap->add_section(
			'ewd-upcp-settings',
			array(
				'id'            => 'ewd-upcp-styling-tab',
				'title'         => __( 'Styling', 'ultimate-product-catalogue' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-styling-catalog',
					'title'         => __( 'Catalog', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-styling-tab',
				),
				$ewd_upcp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'toggle',
			array(
				'id'			=> 'styling-fixed-thumbnail-size',
				'title'			=> __( 'Fixed Thumbnail Size', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Enabling this will make all thumbnails the same size, cropping the image if necessary.', 'ultimate-product-catalogue' ),
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'radio',
			array(
				'id'			=> 'styling-catalog-skin',
				'title'			=> __( 'Catalog Style', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Selects a layout style for your catalog.', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'default'			=> __( 'Default', 'ultimate-product-catalogue' ),
					'main-block'		=> __( 'Block', 'ultimate-product-catalogue' ),
					'main-hover'		=> __( 'Minimalist/Hover', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-catalog-skin']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'radio',
			array(
				'id'			=> 'styling-category-heading-style',
				'title'			=> __( 'Category Heading Style', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Selects a style for the category headings in your catalog views.', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'normal'		=> __( 'Normal', 'ultimate-product-catalogue' ),
					'block'			=> __( 'Block', 'ultimate-product-catalogue' ),
					'none'			=> __( 'Not Displayed', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-category-heading-style']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-action-button-background-color',
				'title'			=> __( 'Action Button Border/Background Hover', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-action-button-text-color',
				'title'			=> __( 'Action Button Text on Hover', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-compare-button-background-color',
				'title'			=> __( 'Compare Button Background', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-compare-button-clicked-background-color',
				'title'			=> __( 'Compare Button Clicked Background', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-compare-button-text-color',
				'title'			=> __( 'Compare Button Text', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-compare-button-clicked-text-color',
				'title'			=> __( 'Compare Button Clicked Text', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'text',
			array(
				'id'            => 'styling-compare-button-font-size',
				'title'         => __( 'Compare Button Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-sale-button-background-color',
				'title'			=> __( 'Sale Button Background', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-sale-button-text-color',
				'title'			=> __( 'Sale Button Text', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'text',
			array(
				'id'            => 'styling-sale-button-font-size',
				'title'         => __( 'Sale Button Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'text',
			array(
				'id'            => 'styling-product-comparison-title-font-size',
				'title'         => __( 'Product Comparison Title Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-product-comparison-title-font-color',
				'title'			=> __( 'Product Comparison Title Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'text',
			array(
				'id'            => 'styling-product-comparison-price-font-size',
				'title'         => __( 'Product Comparison Price Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-product-comparison-price-font-color',
				'title'			=> __( 'Product Comparison Price Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-catalog',
			'colorpicker',
			array(
				'id'			=> 'styling-product-comparison-price-background-color',
				'title'			=> __( 'Product Comparison Price Background Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-styling-thumbnail-view',
					'title'         => __( 'Thumbnail View', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-styling-tab',
				),
				$ewd_upcp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-thumbnail-view-image-border-color',
				'title'			=> __( 'Image Border Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'text',
			array(
				'id'            => 'styling-thumbnail-view-box-min-height',
				'title'         => __( 'Box Min-Height', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'text',
			array(
				'id'            => 'styling-thumbnail-view-box-max-height',
				'title'         => __( 'Box Max-Height', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'text',
			array(
				'id'            => 'styling-thumbnail-view-box-padding',
				'title'         => __( 'Box Padding', 'ultimate-product-catalogue' ),
				'description'	=> 'Applies to the Block catalog style.'
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-thumbnail-view-border-color',
				'title'			=> __( 'Box Border Color', 'ultimate-product-catalogue' ),
				'description'	=> 'Applies to the Block catalog style.'
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'text',
			array(
				'id'            => 'styling-thumbnail-view-title-font',
				'title'         => __( 'Product Title Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'text',
			array(
				'id'            => 'styling-thumbnail-view-title-font-size',
				'title'         => __( 'Product Title Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-thumbnail-view-title-font-color',
				'title'			=> __( 'Product Title Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'text',
			array(
				'id'            => 'styling-thumbnail-view-price-font',
				'title'         => __( 'Product Price Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'text',
			array(
				'id'            => 'styling-thumbnail-view-price-font-size',
				'title'         => __( 'Product Price Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-thumbnail-view-price-font-color',
				'title'			=> __( 'Product Price Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-thumbnail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-thumbnail-view-background-color',
				'title'			=> __( 'Product Background Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-styling-list-view',
					'title'         => __( 'List View', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-styling-tab',
				),
				$ewd_upcp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'radio',
			array(
				'id'			=> 'styling-list-view-click-action',
				'title'			=> __( 'Product Click Action', 'ultimate-product-catalogue' ),
				'description'	=> __( 'When a product is clicked in list view, should the listing expand or should the user be sent to the product page?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'expand'		=> __( 'Expand', 'ultimate-product-catalogue' ),
					'product'		=> __( 'Product Page', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-list-view-click-action']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'colorpicker',
			array(
				'id'			=> 'styling-list-view-image-border-color',
				'title'			=> __( 'Image Border Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'text',
			array(
				'id'            => 'styling-list-view-box-padding',
				'title'         => __( 'Box Padding', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'text',
			array(
				'id'            => 'styling-list-view-box-margin-top',
				'title'         => __( 'Box Top Margin', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'colorpicker',
			array(
				'id'			=> 'styling-list-view-box-border-color',
				'title'			=> __( 'Box Border Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'text',
			array(
				'id'            => 'styling-list-view-title-font',
				'title'         => __( 'Product Title Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'text',
			array(
				'id'            => 'styling-list-view-title-font-size',
				'title'         => __( 'Product Title Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'colorpicker',
			array(
				'id'			=> 'styling-list-view-title-font-color',
				'title'			=> __( 'Product Title Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'text',
			array(
				'id'            => 'styling-list-view-price-font',
				'title'         => __( 'Product Price Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'text',
			array(
				'id'            => 'styling-list-view-price-font-size',
				'title'         => __( 'Product Price Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-list-view',
			'colorpicker',
			array(
				'id'			=> 'styling-list-view-price-font-color',
				'title'			=> __( 'Product Price Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-styling-detail-view',
					'title'         => __( 'Detail View', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-styling-tab',
				),
				$ewd_upcp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-detail-view-image-border-color',
				'title'			=> __( 'Image Border Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'text',
			array(
				'id'            => 'styling-detail-view-box-padding',
				'title'         => __( 'Box Padding', 'ultimate-product-catalogue' ),
				'description'	=> 'Applies to the Block catalog style.'
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'text',
			array(
				'id'            => 'styling-detail-view-box-margin',
				'title'         => __( 'Box Margin', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-detail-view-box-background-color',
				'title'			=> __( 'Box Background Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-detail-view-border-color',
				'title'			=> __( 'Box Border Color', 'ultimate-product-catalogue' ),
				'description'	=> 'Applies to the Block catalog style.'
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'text',
			array(
				'id'            => 'styling-detail-view-title-font',
				'title'         => __( 'Product Title Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'text',
			array(
				'id'            => 'styling-detail-view-title-font-size',
				'title'         => __( 'Product Title Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-detail-view-title-font-color',
				'title'			=> __( 'Product Title Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'text',
			array(
				'id'            => 'styling-detail-view-price-font',
				'title'         => __( 'Product Price Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'text',
			array(
				'id'            => 'styling-detail-view-price-font-size',
				'title'         => __( 'Product Price Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-detail-view',
			'colorpicker',
			array(
				'id'			=> 'styling-detail-view-price-font-color',
				'title'			=> __( 'Product Price Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-styling-sidebar',
					'title'         => __( 'Sidebar', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-styling-tab',
				),
				$ewd_upcp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'toggle',
			array(
				'id'			=> 'styling-sidebar-title-collapse',
				'title'			=> __( 'Collapsible Sidebar', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should sidebar titles collapse on-click?', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'toggle',
			array(
				'id'			=> 'styling-sidebar-start-collapsed',
				'title'			=> __( 'Sidebar Start Collapsed', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Should sidebar content start collapsed? (Requires collapsible sidebar to be set to \'Yes\')', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'radio',
			array(
				'id'			=> 'styling-sidebar-title-hover',
				'title'			=> __( 'Sidebar Title Hover Effect', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Which hover effect should apply on sidebar titles?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'none'			=> __( 'None', 'ultimate-product-catalogue' ),
					'underline'		=> __( 'Underline', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-sidebar-title-hover']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'radio',
			array(
				'id'			=> 'styling-sidebar-checkbox-style',
				'title'			=> __( 'Checkbox Style', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Which style should be applied to the catalog sidebar?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'none'			=> __( 'Default', 'ultimate-product-catalogue' ),
					'square'		=> __( 'Checkmark', 'ultimate-product-catalogue' ),
					'minimalist'	=> __( 'Minimalist', 'ultimate-product-catalogue' ),
					'block'			=> __( 'Block', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-sidebar-checkbox-style']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'radio',
			array(
				'id'			=> 'styling-sidebar-categories-control-type',
				'title'			=> __( 'Categories Control Type', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Which type of control should be used to filter categories?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'checkbox'		=> __( 'Checkbox', 'ultimate-product-catalogue' ),
					'radio'			=> __( 'Radio', 'ultimate-product-catalogue' ),
					'dropdown'		=> __( 'Dropdown', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-sidebar-categories-control-type']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'radio',
			array(
				'id'			=> 'styling-sidebar-subcategories-control-type',
				'title'			=> __( 'Sub-Categories Control Type', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Which type of control should be used to filter sub-categories?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'checkbox'		=> __( 'Checkbox', 'ultimate-product-catalogue' ),
					'radio'			=> __( 'Radio', 'ultimate-product-catalogue' ),
					'dropdown'		=> __( 'Dropdown', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-sidebar-subcategories-control-type']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'radio',
			array(
				'id'			=> 'styling-sidebar-tags-control-type',
				'title'			=> __( 'Tags Control Type', 'ultimate-product-catalogue' ),
				'description'	=> __( 'Which type of control should be used to filter tags?', 'ultimate-product-catalogue' ),
				'options'		=> array(
					'checkbox'		=> __( 'Checkbox', 'ultimate-product-catalogue' ),
					'radio'			=> __( 'Radio', 'ultimate-product-catalogue' ),
					'dropdown'		=> __( 'Dropdown', 'ultimate-product-catalogue' ),
				),
				'default'		=> $this->defaults['styling-sidebar-tags-control-type']
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'ordering-table',
			array(
				'id'            => 'styling-sidebar-items-order',
				'title'         => __( 'Sidebar Items Order', 'ultimate-faqs' ),
				'description'   => __( 'What order should the filtering controls appear in?', 'ultimate-faqs' ), 
				'items'       	=> $this->get_setting( 'styling-sidebar-items-order' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'text',
			array(
				'id'            => 'styling-sidebar-header-font',
				'title'         => __( 'Sidebar Title Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'text',
			array(
				'id'            => 'styling-sidebar-header-font-size',
				'title'         => __( 'Sidebar Title Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'colorpicker',
			array(
				'id'			=> 'styling-sidebar-header-font-color',
				'title'			=> __( 'Sidebar Title Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'text',
			array(
				'id'            => 'styling-sidebar-header-font-weight',
				'title'         => __( 'Sidebar Title Font Weight', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'text',
			array(
				'id'            => 'styling-sidebar-checkbox-font',
				'title'         => __( 'Sidebar Checkbox Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'text',
			array(
				'id'            => 'styling-sidebar-checkbox-font-size',
				'title'         => __( 'Sidebar Checkbox Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'colorpicker',
			array(
				'id'			=> 'styling-sidebar-checkbox-font-color',
				'title'			=> __( 'Sidebar Checkbox Font Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-sidebar',
			'text',
			array(
				'id'            => 'styling-sidebar-checkbox-font-weight',
				'title'         => __( 'Sidebar Checkbox Font Weight', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-styling-product-page',
					'title'         => __( 'Product Page', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-styling-tab',
				),
				$ewd_upcp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-product-page',
			'text',
			array(
				'id'            => 'styling-breadcrumbs-font',
				'title'         => __( 'Breadcrumbs Font', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-product-page',
			'text',
			array(
				'id'            => 'styling-breadcrumbs-font-size',
				'title'         => __( 'Breadcrumbs Font Size', 'ultimate-product-catalogue' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-product-page',
			'colorpicker',
			array(
				'id'			=> 'styling-breadcrumbs-font-color',
				'title'			=> __( 'Breadcrumbs Text Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-product-page',
			'colorpicker',
			array(
				'id'			=> 'styling-breadcrumbs-font-hover-color',
				'title'			=> __( 'Breadcrumbs Text Hover Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_section(
			'ewd-upcp-settings',
			array_merge(
				array(
					'id'            => 'ewd-upcp-styling-pagination',
					'title'         => __( 'Pagination', 'ultimate-product-catalogue' ),
					'tab'	        => 'ewd-upcp-styling-tab',
				),
				$ewd_upcp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-pagination',
			'colorpicker',
			array(
				'id'			=> 'styling-pagination-background-color',
				'title'			=> __( 'Background Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-pagination',
			'colorpicker',
			array(
				'id'			=> 'styling-pagination-text-color',
				'title'			=> __( 'Text Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-pagination',
			'colorpicker',
			array(
				'id'			=> 'styling-pagination-background-color-hover',
				'title'			=> __( 'Background Hover Color', 'ultimate-product-catalogue' )
			)
		);

		$sap->add_setting(
			'ewd-upcp-settings',
			'ewd-upcp-styling-pagination',
			'colorpicker',
			array(
				'id'			=> 'styling-pagination-text-color-hover',
				'title'			=> __( 'Text Hover Color', 'ultimate-product-catalogue' )
			)
		);

		$sap = apply_filters( 'ewd_upcp_settings_page', $sap );

		$sap->add_admin_menus();

	}

	/**
	 * Return existing custom fields
	 * @since 5.0.0
	 */
	public function get_custom_fields() {

		if ( ! isset( $this->custom_fields ) ) {

			$this->custom_fields = is_array( get_option( 'ewd-upcp-custom-fields' ) ) ? get_option( 'ewd-upcp-custom-fields' ) : array();
		}

		return $this->custom_fields;
	}

	/**
	 * Sets new value for the custom fields option
	 * @since 5.0.0
	 */
	public function update_custom_fields( $custom_fields ) {

		$custom_fields = is_array( $custom_fields ) ? $custom_fields : array();

		$this->custom_fields = $custom_fields;

		update_option( 'ewd-upcp-custom-fields', $custom_fields );
	}

	/**
	 * Adds/removes the product editing capabilities as necessary
	 * @since 5.0.0
	 */
	public function manage_user_capabilities() {
		global $ewd_upcp_controller;

		$manage_products_roles = array(
			'administrator',
		);

		$remove_product_roles = array();

		if ( $this->get_setting( 'access-role' ) == 'administrator' ) {

			$remove_product_roles[] = 'editor';
			$remove_product_roles[] = 'author';
			$remove_product_roles[] = 'contributor';
		}
		elseif ( $this->get_setting( 'access-role' ) == 'delete_others_pages' ) {

			$manage_products_roles[] = 'editor';

			$remove_product_roles[] = 'author';
			$remove_product_roles[] = 'contributor';
		}
		elseif ( $this->get_setting( 'access-role' ) == 'delete_published_posts' ) {

			$manage_products_roles[] = 'editor';
			$manage_products_roles[] = 'author';

			$remove_product_roles[] = 'contributor';
		}
		elseif ( $this->get_setting( 'access-role' ) == 'delete_posts' ) {

			$manage_products_roles[] = 'editor';
			$manage_products_roles[] = 'author';
			$manage_products_roles[] = 'contributor';
		}

		$capabilities = array(
			'edit_upcp_product',
			'read_upcp_product',
			'delete_upcp_product',
			'delete_upcp_products',
			'delete_private_upcp_products',
			'delete_published_upcp_products',
			'delete_others_upcp_products',
			'edit_upcp_products',
			'edit_private_upcp_products',
			'edit_published_upcp_products',
			'edit_others_upcp_products',
			'publish_upcp_products',
			'read_private_upcp_products',
		);

		$args = array(
			'post_type' 	=> EWD_UPCP_PRODUCT_POST_TYPE,
			'numberposts'	=> 100,
		);

		$products = get_posts( $args );

		if ( $ewd_upcp_controller->permissions->check_permission( 'premium' ) or sizeof( $products ) < 100 ) { 

			$capabilities[] = 'create_upcp_products';
		}
		
		foreach ( $manage_products_roles as $role ) {

			$role_object = get_role( $role );

			foreach ( $capabilities as $capability ) {

				$role_object->add_cap( $role, $capability );
			}
		}

		foreach ( $remove_product_roles as $role ) {

			$role_object = get_role( $role );

			foreach ( $capabilities as $capability ) {

				$role_object->remove_cap( $role, $capability );
			}
		}
	}

	/**
	 * Creates the product inquiry form using the selected plugin
	 * @since 5.0.0
	 */
	public function create_product_inquiry_form() {

		if ( empty( $this->get_setting( 'product-inquiry-form' ) ) and empty( $this->get_setting( 'product-inquiry-cart' ) ) ) { return; }

		if ( $this->get_setting( 'product-inquiry-plugin' ) == 'cf7' ) {

			$this->create_cf7_product_inquiry_form();
		}
		else {

			$this->create_wp_forms_product_inquiry_form();
		}
	}

	/**
	 * Creates the product inquiry for Contact Form 7
	 * @since 5.0.0
	 */
	public function create_cf7_product_inquiry_form() {
		
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) { return; }

		$admin_email = get_option( 'admin_email' );
		$blogname = get_option( 'blogname' );
		$site_url = get_bloginfo( 'siteurl' );

		$product_inquiry_form = get_page_by_path( 'upcp-product-inquiry-form', OBJECT, 'wpcf7_contact_form' );

		if ( $product_inquiry_form ) { return; }

		$post = array(
			'post_name' => 'upcp-product-inquiry-form',
			'post_title' => 'UPCP Inquiry Form',
			'post_type' => 'wpcf7_contact_form',
			'post_content' => 
'<p>Your Name (required)<br />
    [text* your-name] </p>
				
<p>Your Email (required)<br />
    [email* your-email] </p>

<p>Inquiry Product Name<br />
    [text product-name "%PRODUCT_NAME%"] </p>

<p>Your Message<br />
    [textarea your-message] </p>

<p>[submit "Send"]</p>
Product Inquiry E-mail
[your-name] <' . $admin_email . '>
From: [your-name] <[your-email]>
Interested Product: [product-name]

Message Body:
[your-message]

--
This e-mail was sent from a contact form on ' . $blogname . ' (' . $site_url . ')
' . $admin_email . '
Reply-To: [your-email]

0
0

[your-subject]
' . $blogname . ' <' . $admin_email . '>
Message Body:
[your-message]

--
This e-mail was sent from a contact form on ' . $blogname . ' (' . $site_url . ')
[your-email]
Reply-To: ' . $admin_email . '

0
0
Your message was sent successfully. Thanks.
Failed to send your message. Please try later or contact the administrator by another method.
Validation errors occurred. Please confirm the fields and submit it again.
Failed to send your message. Please try later or contact the administrator by another method.
Please accept the terms to proceed.
Please fill in the required field.
This input is too long.
This input is too short.
			');
		
		$post_id = wp_insert_post( $post );

		if ( $post_id ) {
				$mail_array = array(
				'subject' => 'Product Inquiry E-mail',
				'sender' => $blogname . ' <' . $admin_email . '>',
				'body' => 'From: [your-name] <[your-email]>
Interested Product: [product-name]

Message Body:
[your-message]

--
This e-mail was sent from a contact form on ' . $blogname . ' (' . $site_url . ')',
				'recipient' => $admin_email,
				'additional_headers' => 'Reply-To: [your-email]',
				'attachments' => '',
				'use_html' => 0,
				'exclude_blank' => 0
			);

			add_post_meta( $post_id, "_mail", $mail_array );
			add_post_meta( $post_id, "_form", 
'<p>Your Name (required)<br />
    [text* your-name] </p>
				
<p>Your Email (required)<br />
    [email* your-email] </p>

<p>Inquiry Product Name<br />
    [text product-name "%PRODUCT_NAME%"] </p>

<p>Your Message<br />
    [textarea your-message] </p>

<p>[submit "Send"]</p>
			');
			add_post_meta( $post_id, "_mail_2", $mail_array );
			add_post_meta( $post_id, "_messages", array(
				"mail_sent_ok",
				"Your message was sent successfully. Thanks.",
				"mail_sent_ng",
				"Failed to send your message. Please try later or contact the administrator by another method.",
				"validation_error",
				"Validation errors occurred. Please confirm the fields and submit it again.",
				"spam",
				"Failed to send your message. Please try later or contact the administrator by another method.",
				"accept_terms",
				"Please accept the terms to proceed.",
				"invalid_required",
				"Please fill in the required field.",
				"invalid_too_long",
				"This input is too long.",
				"invalid_too_short",
				"This input is too short."
				)
			);

			add_post_meta( $post_id, "_additional_settings", '' );
			add_post_meta( $post_id, "_locale", 'en_US' );
		}
	}

	/**
	 * Creates the product inquiry for WP Forms
	 * @since 5.0.0
	 */
	public function create_wp_forms_product_inquiry_form() {

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if ( ! is_plugin_active( 'wpforms/wpforms.php' ) and ! is_plugin_active( 'wpforms-lite/wpforms.php' ) ) { return; }

		$product_inquiry_form = get_page_by_path( 'upcp-wp-forms-product-inquiry-form', OBJECT, 'wpforms' );

		if ( $product_inquiry_form ) { return; }

		$post = array(
			'post_name' 	=> 'upcp-wp-forms-product-inquiry-form',
			'post_title' 	=> 'UPCP Inquiry Form',
			'post_type' 	=> 'wpforms',
			'post_status' 	=> 'publish',
			'post_content' 	=> 'placeholder'
		);

		$post_id = wp_insert_post($post);
		
		if ( $post_id ) {

			$update = array(
				'ID' 			=> $post_id,
				'post_content' 	=> '{"id":"' . $post_id . '","field_id":5,"fields":{"1":{"id":"1","type":"text","label":"Your Name","description":"","required":"1","size":"medium","placeholder":"","default_value":"","css":"","input_mask":""},"3":{"id":"3","type":"email","label":"Your Email","description":"","required":"1","size":"medium","placeholder":"","confirmation_placeholder":"","default_value":"","css":""},"2":{"id":"2","type":"text","label":"Inquiry Product Name","description":"","size":"medium","placeholder":"","default_value":"%PRODUCT_NAME%","css":"","input_mask":""},"4":{"id":"4","type":"textarea","label":"Your Message","description":"","size":"medium","placeholder":"","css":""}},"settings":{"form_title":"Product Inquiry E-mail","form_desc":"","form_class":"","submit_text":"Send","submit_text_processing":"Sending...","submit_class":"","honeypot":"1","notification_enable":"1","notifications":{"1":{"notification_name":"Default Notification","email":"{admin_email}","subject":"New Blank Form Entry","sender_name":"Demo Theme Test Setup","sender_address":"{admin_email}","replyto":"","message":"{all_fields}"}},"confirmation_type":"message","confirmation_message":"Thanks for inquiring! We will be in touch with you shortly.","confirmation_message_scroll":"1","confirmation_page":"11573","confirmation_redirect":""},"meta":{"template":"blank"}}'
			);

			wp_update_post( $update );
		}
	}
}
} // endif;
