<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/** nav-menu-walker.php */
class hotelgalaxy_wp_bootstrap_navwalker extends Walker_Nav_Menu {	

	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		$megha_menu = '';
		if(hotelgalaxy_get_option('is_megha_menu')){
			$megha_menu = 'megamenu';
		}

		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown-menu $megha_menu\">\n";

	}

	public function hotelgalaxy_start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ($args->has_children && $depth > 0) {

			$classes[] = 'dropdown-submenu';

		} else if($args->has_children && $depth === 0) {

			$classes[] = 'dropdown';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );		

		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );

		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		// $attributes .= ($args->has_children) 	    ? ' data-toggle="dropdown" data-target="#" class="dropdown-toggle"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

		$item_output .= in_array('dropdown', $classes) ? '<span class="caret"></span>': '' ;
		$item_output .= in_array('dropdown-submenu', $classes) ? '<span class="caret"></span>': '' ;
		
		$item_output .= ($args->has_children) ? '</a>' : '</a>';
		
		$item_output .= $args->after;

		
		$output .= apply_filters( 'walker_nav_menu_hotelgalaxy_start_el', $item_output, $item, $depth, $args );
	}


	public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'hotelgalaxy_start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array($this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array($this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'end_el'), $cb_args);
	}

	public static function fallback ( $args = array() ) {

		if ( current_user_can( 'edit_theme_options' ) ) {

				// Get Arguments.
			$container       = $args['container'];
			$container_id    = $args['container_id'];
			$container_class = $args['container_class'];
			$menu_class      = $args['menu_class'];
			$menu_id         = $args['menu_id'];

				// Initialize var to store fallback html.
			$fallback_output = '';

			if ( $container ) {
				$fallback_output .= '<' . esc_attr( $container );
				if ( $container_id ) {
					$fallback_output .= ' id="' . esc_attr( $container_id ) . '"';
				}
				if ( $container_class ) {
					$fallback_output .= ' class="' . esc_attr( $container_class ) . '"';
				}
				$fallback_output .= '>';
			}

			$fallback_output .= '<ul';

			if ( $menu_id ) {
				$fallback_output .= ' id="' . esc_attr( $menu_id ) . '"'; 
			}
			if ( $menu_class ) {
				$fallback_output .= ' class="' . esc_attr( $menu_class ) . '"'; 
			}

			$fallback_output .= '>';
			$fallback_output .= '<li class="menu-item nav-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="nav-link" title="' . esc_attr__( 'Add a menu', 'hotel-galaxy' ) . '">' . esc_html__( 'Add a menu', 'hotel-galaxy' ) . '</a></li>';
			$fallback_output .= '</ul>';

			if ( $container ) {
				$fallback_output .= '</' . esc_attr( $container ) . '>';
			}

				// If $args has 'echo' key and it's true echo, otherwise return.
			if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
					echo $fallback_output; // WPCS: XSS OK.
				} else {
					return $fallback_output;
				}
			}
		}

	}



	function hotelgalaxy_add_nav_menu_css_class( $classes ) {

		if ( in_array('current-menu-item', $classes ) OR in_array( 'current-menu-ancestor', $classes ) )
			$classes[]	=	'active';

		return $classes;
	}


	add_filter( 'nav_menu_css_class', 'hotelgalaxy_add_nav_menu_css_class' );


	?>