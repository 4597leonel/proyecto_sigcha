<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> >

	<?php 

	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} 
	
	do_action('hotelgalaxy_pre_loader');
	?>		

	<div id="header-container" <?php hotelgalaxy_add_class( 'header_layout' ) ?>>

		<?php do_action('hotelgalaxy_before_header'); ?>	

		<header id="mastser-header" class="mastser-header site-header wow fadeInLeft" role="header">

			<div class="container">

				<?php 

				do_action('hotelgalaxy_add_logo');

				do_action('hotelgalaxy_menu'); 

				?>

			</div>

		</header>

		<?php do_action('hotelgalaxy_after_header'); ?>	

	</div>
	
	<div id="hg-wrapper" class="clearfix">

		<?php do_action( 'hotelgalaxy_page_breadcrums' ) ?>