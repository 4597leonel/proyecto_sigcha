<?php 

function hotel_galaxy_one_get_starter_content() { 

	$starter_content = array(

		'posts'     => array(
			'front' => array(
				'post_type'    => 'page',
				
				'post_title'   => esc_html_x( 'Welcome To Hotel Galaxy Theme', 'Theme starter content', 'hotel-galaxy' ),
				'post_content' => _x( 'Welcome to your site', 'hotel-galaxy' ),
			),
			
			'about',
			'blog',
			'contact',			
		),

		'options'   => array(
			'show_on_front'  => 'page',
			'page_on_front'  => '{{front}}',
			'page_for_posts' => '{{blog}}',
		),

		'nav_menus' => array(

			'primary' => array(
				'name'  => esc_html__( 'Primary menu', 'hotel-galaxy' ),
				'items' => array(
					'link_home',
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

		),
	

	'widgets' => array(		
		'footer-widget-area' => array( 	
			'my_text' => array(	'text', array(
					'title' => _x('About US', 'Theme starter content', 'hotel-galaxy'),
					'text'  => _x('Welcome to your site', 'Theme starter content', 'hotel-galaxy')
				)
			),

			'categories' => array( 'categories', array(
				'title' => _x( 'Categories', 'Theme starter content', 'hotel-galaxy' ),
			) ),

			'recent-posts' => array( 'recent-posts', array(
				'title' => _x( 'Recent Posts', 'Theme starter content', 'hotel-galaxy' ),
			) ),

			'search' => array( 'search', array(
				'title' => _x( 'Search', 'Theme starter content', 'hotel-galaxy' ),
			) ),			
		),
		
	),

	);

	return apply_filters( 'hotel_galaxy_one_starter_content', $starter_content );
}
?>