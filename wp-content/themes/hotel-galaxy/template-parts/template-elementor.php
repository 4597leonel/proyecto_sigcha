<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/*
	Template Name: Elementor Full Width
*/
	get_header();

	?>

	<div class="container">

		<main class="content-area">
			<div class="row">

				<div class="col-md-12">	
					<?php
					while ( have_posts() ) : the_post();

						the_content();

					endwhile;
					?>
				</div>
			</div>
		</main>
	</div>

	<?php

	get_footer();	

	?>