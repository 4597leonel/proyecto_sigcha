<?php 

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header(); 

?>

<div class="container">

	<div class="content-area">

		<div class="row">

			<div class="col-md-8">		

				<div class="inside-article wow fadeInUp">	

					<h2><?php esc_html_e( 'Oops! That page can not be found.', 'hotel-galaxy'); ?></h2>					

					<div class="entry-content">

						<p> <?php esc_html_e( 'It looks like nothing was found at this location.', 'hotel-galaxy'); ?></p>

						<?php  get_search_form(); ?>
					</div>

				</div>
			</div>	

			<div class="col-md-4">

				<?php get_sidebar(); ?>

			</div>

		</div>
	</div>
</div>	

<?php get_footer(); ?>