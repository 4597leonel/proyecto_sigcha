<?php 

 if ( ! defined( 'ABSPATH' ) ) { exit; }

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

	<div class="inside-article wow fadeInUp">	

		<div class="entry-content" itemprop="text">

			<?php

			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html( 'Pages:', 'hotel-galaxy'),
				'after'  => '</div>',
			) );

			?>
			
		</div>

	</div>

</article>