<?php

 if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'HotelGalaxy_Version', '4.4' );

define( 'HOTEL_PARENT_DIR', get_template_directory() );
define( 'HOTEL_PARENT_URI', get_template_directory_uri() );

define( 'HOTEL_PARENT_INC_DIR', HOTEL_PARENT_DIR . '/inc' );
define( 'HOTEL_PARENT_INC_URI', HOTEL_PARENT_URI . '/inc' );

/**
 * All necessary theme files
 */


$theme_path = get_template_directory();


require $theme_path . '/inc/structure/theme_setup.php';

require $theme_path . '/inc/service-widget.php';

require $theme_path . '/inc/structure/wp_enqueue.php';

require $theme_path . '/inc/structure/bootstrap_navwalker.php';

require $theme_path . '/inc/structure/post-meta.php';

require $theme_path . '/inc/structure/header.php';

require $theme_path .'/inc/structure/sidebar_widget.php' ;

require $theme_path . '/inc/structure/breadcrumbs.php';

require $theme_path . '/inc/structure/featured-images.php';

require $theme_path . '/inc/structure/read-more-btn.php';

require $theme_path . '/inc/structure/comment-form.php';

require $theme_path . '/inc/structure/footer.php';

require $theme_path . '/inc/defaults.php';

require $theme_path . '/inc/theme-helpers.php';

require $theme_path . '/inc/google-fonts.php';

require $theme_path . '/inc/markup.php';

require $theme_path . '/inc/migrate.php';

require $theme_path . '/inc/dashboard.php';

require $theme_path . '/inc/customizer.php';

require $theme_path . '/inc/customizer/typography-helpers.php';

require $theme_path . '/inc/classes/class-css.php';

require $theme_path . '/inc/css-output.php';

require $theme_path . '/inc/plugin-woocommerce.php';

require $theme_path . '/inc/icons.php';


