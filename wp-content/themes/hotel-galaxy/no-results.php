<?php 

 if ( ! defined( 'ABSPATH' ) ) { exit; }

?>

<div class="inside-article wow fadeInUp">

	<header class="entry-header">

		<h1 class="entry-title">

			<?php esc_html_e( 'Oops! That page can not be found.', 'hotel-galaxy'); ?>

		</h1>

	</header>

	<div class="entry-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p>
			<?php
			printf( _e( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'hotel-galaxy'),
				esc_url( admin_url( 'post-new.php' ) )
			);
			?>
		</p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php esc_html_e( 'It looks like nothing was found at this location.', 'hotel-galaxy');  ?>

			</p>
			<?php get_search_form(); ?>

			<?php else : ?>

				<p>
					<?php esc_html_e( 'It looks like nothing was found at this location.', 'hotel-galaxy');  ?>

				</p>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</div><!-- .entry-content -->
	</div>