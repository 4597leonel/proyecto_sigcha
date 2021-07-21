<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
  }

  if(! function_exists('hotelgalaxy_add_page_header')){

    add_action('hotelgalaxy_page_breadcrums','hotelgalaxy_add_page_header');

    function hotelgalaxy_add_page_header(){ 

      $post_types = array('hg_room');

      $template_list = array('home-default','template-elementor', 'home-1', 'home-2', 'home-3', 'home-4', 'home-5');  

      if ( is_single() && in_array( get_post_type(), $post_types) ) {
        return false;
      }

      if( in_array( hotelgalaxy_current_template_name(), $template_list ) ){

        return false;
      }      

      ?>
      <div id="breadcrumb-section">       

        <div class="overlay clearfix">
          <div class="container content_center wow fadeInUp">

            <?php hotelgalaxy_the_breadcrumb() ?>

          </div>
        </div>
      </div>

      <?php
    }
  }

  function hotelgalaxy_the_breadcrumb(){ 

    $before = '<div class="col-lg-12 "> <div class="col-lg-8">';
    $after = '</div></div> ';

    global $post;  

    if ( is_page() ) { ?>


      <div id="trapezoid">

        <h2 class="breadcrumb-title"> <?php echo esc_html( get_the_title() ) ?> </h2>      

        <ul class="breadcrum-list">

          <li><a href="<?php echo esc_url( home_url() ) ?>"><?php esc_html_e('Home', 'hotel-galaxy') ?></a> </li>

          <li class="active"><?php echo esc_html( get_the_title() ) ?></li>

        </ul>

      </div>;

      <?php
    }elseif(function_exists('is_woocommerce') && is_woocommerce()) { ?>

      <div id="trapezoid">

       <h2 class="breadcrumb-title"> <?php echo esc_html( woocommerce_page_title( false ) ) ?></h2>      

       <ul class="breadcrum-list">
        
         <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home', 'hotel-galaxy') ?></a> </li>

         <li class="active"><?php echo esc_html( woocommerce_page_title( false ) ) ?></li>

       </ul>

     </div>

     <?php

   }elseif ( is_home() || is_front_page()) { ?>

     <div id="trapezoid">

      <h2 class="breadcrumb-title"> <?php echo esc_html( wp_title( '',false ) ) ?></h2>       

      <ul class="breadcrum-list">

        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"> <?php esc_html_e('Home', 'hotel-galaxy') ?></a> </li>

        <li class="active"><?php echo esc_html( wp_title('', false ) ) ?></li>

      </ul>

    </div>     

  <?php }elseif( is_tag() ){
   echo $before;
   ?>
   <h2 class="breadcrumb-title"><?php echo esc_html( wp_title('Tag&nbsp;&#8282;&nbsp;', false) ) ?></h2>
   <?php
   echo $after;

 }elseif( is_author() ){

  echo $before; ?>
  <h2 class="breadcrumb-title"><?php echo esc_html( wp_title('Author&nbsp;&#8282;&nbsp;', false) ) ?></h2>
  <?php echo $after;

}elseif( is_archive() ){

 echo $before; ?>
 <h2 class="breadcrumb-title"> <?php echo esc_html( single_cat_title('Category &nbsp;&#8282;&nbsp;', false) ) ?></h2>
 <?php 
 echo $after;

}elseif (is_404()) { ?>

 <div id="trapezoid">

  <h2 class="breadcrumb-title"><?php esc_html_e( __('404','hotel-galaxy') ) ?></h2> 

</div>';

<?php }elseif ( is_single() && !is_attachment() ){

 echo $before;

 if (get_post_type() != 'post') {
  echo the_title('<h2 class="breadcrumb-title">','</h2>');

}else{

 $cat = get_the_category();
 $cat = $cat[0]; 

 echo sprintf('<p class="breadcrumb-category">%s</p>', get_category_parents($cat, true,''));
 echo the_title('<h2 class="breadcrumb-title">','</h2>');

}

echo $after;  


}elseif (is_search()) {

  echo $before;
  
  echo sprintf('<h2 class="breadcrumb-title">Search results for " %s "</h2>',esc_html( get_search_query( false ) ));
  echo $after;

}

}


?>