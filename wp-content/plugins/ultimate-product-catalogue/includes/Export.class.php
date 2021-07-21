<?php

/**
 * Class to export products created by the plugin
 */

if ( !defined( 'ABSPATH' ) )
	exit;

if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) { require_once EWD_UPCP_PLUGIN_DIR . '/lib/PHPSpreadsheet/vendor/autoload.php'; }
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
class ewdupcpExport {

	// Set whether a valid nonce is needed before exporting products
	public $nonce_check = true;

	public function __construct() {
		add_action( 'admin_menu', array($this, 'register_install_screen' ));

		if ( isset( $_POST['ewd_upcp_export'] ) ) { add_action( 'admin_menu', array($this, 'export_products' )); }

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_export_scripts' ) );
	}

	public function register_install_screen() {
		global $ewd_upcp_controller;
		
		add_submenu_page( 
			'edit.php?post_type=upcp_product', 
			'Export Menu', 
			'Export', 
			$ewd_upcp_controller->settings->get_setting( 'access-role' ), 
			'ewd-upcp-export', 
			array($this, 'display_export_screen') 
		);
	}

	public function display_export_screen() {
		global $ewd_upcp_controller;

		$export_permission = $ewd_upcp_controller->permissions->check_permission( 'export' );

		?>
		<div class='wrap'>
			<h2>Export</h2>
			<?php if ( $export_permission ) { ?> 
				<form method='post'>
					<?php wp_nonce_field( 'EWD_UPCP_Export', 'EWD_UPCP_Export_Nonce' );  ?>
					<input type='submit' name='ewd_upcp_export' value='Export to Spreadsheet' class='button button-primary' />
				</form>
			<?php } else { ?>
				<div class='ewd-upcp-premium-locked'>
					<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UPCP&Quantity=1" target="_blank">Upgrade</a> to the premium version to use this feature
				</div>
			<?php } ?>
		</div>
	<?php }

	public function export_products() {
		global $ewd_upcp_controller;

		if ( $this->nonce_check and ! isset( $_POST['EWD_UPCP_Export_Nonce'] ) ) { return; }

    	if ( $this->nonce_check and ! wp_verify_nonce( $_POST['EWD_UPCP_Export_Nonce'], 'EWD_UPCP_Export' ) ) { return; }

		$custom_fields = $ewd_upcp_controller->settings->get_custom_fields();

		// Instantiate a new PHPExcel object
		$spreadsheet = new Spreadsheet();
		// Set the active Excel worksheet to sheet 0
		$spreadsheet->setActiveSheetIndex(0);

		// Print out the regular product field labels
		$spreadsheet->getActiveSheet()->setCellValue( 'A1', 'Name' );
		$spreadsheet->getActiveSheet()->setCellValue( 'B1', 'Slug' );
		$spreadsheet->getActiveSheet()->setCellValue( 'C1', 'Description' );
		$spreadsheet->getActiveSheet()->setCellValue( 'D1', 'Price' );
		$spreadsheet->getActiveSheet()->setCellValue( 'E1', 'Sale Price' );
		$spreadsheet->getActiveSheet()->setCellValue( 'F1', 'Image' );
		$spreadsheet->getActiveSheet()->setCellValue( 'G1', 'Link' );
		$spreadsheet->getActiveSheet()->setCellValue( 'H1', 'Category' );
		$spreadsheet->getActiveSheet()->setCellValue( 'I1', 'Sub-Category' );
		$spreadsheet->getActiveSheet()->setCellValue( 'J1', 'Tags' );

		$column = 'K';
		foreach ( $custom_fields as $custom_field ) {

			$spreadsheet->getActiveSheet()->setCellValue( $column . '1', $custom_field->name );
    		$column++;
		}

		//start while loop to get data
		$row_count = 2;

		$args = array(
			'posts_per_page'	=> -1,
			'post_type'			=> EWD_UPCP_PRODUCT_POST_TYPE,
		);

		$product_posts = get_posts( $args );

		foreach ( $product_posts as $product_post ) {

			$product = new ewdupcpProduct();

			$product->load_wp_post( $product_post );

    	 	$spreadsheet->getActiveSheet()->setCellValue( 'A' . $row_count, $product->name );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'B' . $row_count, $product->slug );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'C' . $row_count, $product->description );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'D' . $row_count, $product->regular_price );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'E' . $row_count, $product->sale_price );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'F' . $row_count, $product->get_main_image_url() );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'G' . $row_count, $product->link );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'H' . $row_count, $product->get_category_names() );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'I' . $row_count, $product->get_subcategory_names() );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'J' . $row_count, $product->get_tag_names() );

			$column = 'K';
			foreach ( $custom_fields as $custom_field ) {

				$spreadsheet->getActiveSheet()->setCellValue( $column . $row_count, $product->custom_fields[ $custom_field->id ] );
   				$column++;
			}
			
    		$row_count++;
		}

		// Redirect output to a client’s web browser (Excel5)
		if ( ! isset( $format_type ) == 'csv' ) {

			ob_clean();

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="products_export.csv"');
			header('Cache-Control: max-age=0');
			$objWriter = new Csv($spreadsheet);
			$objWriter->save('php://output');
			die();
		}
		else {

			ob_clean();

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="products_export.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = new Xls($spreadsheet);
			$objWriter->save('php://output');
			die();
		}
	}

	public function enqueue_export_scripts() {

		$screen = get_current_screen();

		if ( $screen->id == 'ewd-upcp-tracking_page_ewd-upcp-export' ) {

			wp_enqueue_style( 'ewd-upcp-admin-css', EWD_UPCP_PLUGIN_URL . '/assets/css/ewd-upcp-admin.css', array(), EWD_UPCP_VERSION );
			wp_enqueue_script( 'ewd-upcp-admin-js', EWD_UPCP_PLUGIN_URL . '/assets/js/ewd-upcp-admin.js', array( 'jquery' ), EWD_UPCP_VERSION, true );
		}
	}

}


