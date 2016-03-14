<?php
/**
 * Divine.
 *
 * @package      Divine
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 3/11/2015
 * @license      GPL-2.0+
 */

//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent. 

//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add Color Selection to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Enqueue Google fonts, Responsive Menu, and Dashicons
add_action( 'wp_enqueue_scripts', 'divine_google_fonts' );
function divine_google_fonts() {
	wp_enqueue_script( 'divine-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=EB+Garamond|Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic,800,800italic|Source+Serif+Pro', array() );
	wp_enqueue_style( 'dashicons' );
}

//* Add new image sizes
add_theme_support( 'post-thumbnails' );
add_image_size( 'blog-square-featured', 400, 400, true );
add_image_size( 'blog-vertical-featured', 400, 600, true );
add_image_size( 'sidebar-featured', 125, 125, true );
add_image_size( 'large-featured', 750, 500, true );

add_image_size( 'homeslider-thumb', 378, 568, true );
add_image_size( 'single-cheese-thumb', 555, 555, true );
add_image_size( 'likes-thumb', 215, 315, true );
add_image_size( 'widget-thumb', 365, 320, true );
add_image_size( 'third-thumb', 365, 365, true );
add_image_size( 'award-thumb', 240, 360, true );
add_image_size( 'event-thumb', 110, 100, true );
add_image_size( 'award-pastil-thumb', 90, 90, true );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 660,
	'height'          => 272,
	'flex-width'      => false,
	'flex-height'     => false,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Hooks widget area above header
add_action( 'genesis_before', 'divine_widget_above_header' );
function divine_widget_above_header() {
	genesis_widget_area( 'widget-above-header', array(
		'before' => '<div class="widget-above-header widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Reposition the secondary navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' );

//* Add widget to secondary navigation
add_filter( 'genesis_nav_items', 'divine_social_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'divine_social_icons', 10, 2 );

function divine_social_icons( $menu, $args ) {
	$args = (array) $args;
	if ( 'secondary' !== $args['theme_location'] ) {
		return $menu;
	}
	ob_start();
	genesis_widget_area( 'nav-social-menu' );
	$social = ob_get_clean();

	return $menu . $social;
}

//* Position post info above post title
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

//* Customize the Post Info Function
add_filter( 'genesis_post_info', 'divine_post_info_filter' );
function divine_post_info_filter( $post_info ) {

	$post_info = '[post_categories before="" sep=""]';

	return $post_info;

}

//* Customize the Post Meta function
add_filter( 'genesis_post_meta', 'divine_post_meta_filter' );
//remove_filter('genesis_post_meta', 'divine_post_meta_filter');
function divine_post_meta_filter( $post_meta ) {

	if ( is_home() ) {

		$post_meta = '<span class="dashicons dashicons-format-chat"></span><br>[post_comments]';

		return $post_meta;
	}
}

//* Add post navigation (requires HTML5 support)
add_action( 'genesis_entry_footer', 'genesis_prev_next_post_nav', 15 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Hooks before-content widget area to single posts
add_action( 'genesis_before_content', 'divine_before_content' );
function divine_before_content() {

	if ( ! is_home() ) {
		return;
	}

	genesis_widget_area( 'before-content', array(
		'before' => '<div class="before-content widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Add split sidebars underneath the primary sidebar
add_action( 'genesis_after_sidebar_widget_area', 'divine_split_sidebars' );
function divine_split_sidebars() {
	foreach ( array( 'sidebar-split-left', 'sidebar-split-right', 'sidebar-split-bottom' ) as $area ) {
		echo '<div class="' . $area . '">';
		dynamic_sidebar( $area );
		echo '</div><!-- end #' . $area . '-->';
	}
}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'divine_read_more_link' );
function divine_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">' . __( 'continue reading...', 'divine' ) . '</a>';
}

//* Hooks widget area before footer
add_action( 'genesis_after', 'divine_widget_before_footer' );
function divine_widget_before_footer() {

	genesis_widget_area( 'widget-before-footer', array(
		'before' => '<div class="widget-before-footer widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Reposition the footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after', 'genesis_footer_widget_areas' );

//* Reposition the footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_after', 'genesis_do_footer', 12 );
add_action( 'genesis_after', 'genesis_footer_markup_close', 13 );

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'divine_remove_comment_form_allowed_tags' );
function divine_remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';

	return $defaults;
}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'divine_comments_gravatar' );
function divine_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'divine_author_box_gravatar' );
function divine_author_box_gravatar( $size ) {

	return 125;

}

//* Customize the credits 
add_filter( 'genesis_footer_creds_text', 'divine_custom_footer_creds_text' );
function divine_custom_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date( 'Y' );
	echo ' &middot; <a target="_blank" href="' . home_url() . '">' . __( 'Fromagerie Îles-aux-Grues | All rights reserved', 'divine' ) . '</a> | <a target="_blank" href="http://www.jtan.ca/">Jtan.ca</a>';
	echo '</p></div>';

}

//* Add Theme Support for WooCommerce
add_theme_support( 'genesis-connect-woocommerce' );

//* Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//* Remove Add to Cart on Archives
add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );
function remove_add_to_cart_buttons() {

	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

}

//* Change number or products per row to 3
add_filter( 'loop_shop_columns', 'loop_columns' );
if ( ! function_exists( 'loop_columns' ) ) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

//* Display 12 products per page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );


//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'sidebar-split-left',
	'name'        => __( 'Sidebar Split Left', 'divine' ),
	'description' => __( 'This is the left side of the split sidebar', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sidebar-split-right',
	'name'        => __( 'Sidebar Split Right', 'divine' ),
	'description' => __( 'This is the right side of the split sidebar', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sidebar-split-bottom',
	'name'        => __( 'Sidebar Split Bottom', 'divine' ),
	'description' => __( 'This is the bottom of the split sidebar', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-content',
	'name'        => __( 'Home - Before Content', 'divine' ),
	'description' => __( 'This is the slider section on the home page.', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-slider',
	'name'        => __( 'Home - Slider', 'divine' ),
	'description' => __( 'This is the slider section on the home page.', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'divine' ),
	'description' => __( 'This is the top section of the home page.', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-triple-bottom',
	'name'        => __( 'Home - Triple Bottom', 'divine' ),
	'description' => __( 'This is the bottom section of the home page.', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-double-bottom',
	'name'        => __( 'Home - Double Bottom', 'divine' ),
	'description' => __( 'This is the bottom section of the home page.', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'category-index',
	'name'        => __( 'Category Index', 'divine' ),
	'description' => __( 'This is the category index for the category index page template.', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'widget-above-header',
	'name'        => __( 'Widget Above Header', 'divine' ),
	'description' => __( 'This is the widget area above the header', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'widget-before-footer',
	'name'        => __( 'Widget Before Footer', 'divine' ),
	'description' => __( 'This is the widget area above the header', 'divine' ),
) );
genesis_register_sidebar( array(
	'id'          => 'nav-social-menu',
	'name'        => __( 'Nav Social Menu', 'divine' ),
	'description' => __( 'This is the nav social menu section.', 'divine' ),
) );

// adding PO Edit file to translate
add_action( 'after_setup_theme', 'languages_child_theme_setup' );
function languages_child_theme_setup() {
	load_child_theme_textdomain( 'divine', get_stylesheet_directory() . '/languages' );
}

// ajout de font awesome
add_action( 'wp_enqueue_scripts', 'font_awesome_script' );
function font_awesome_script() {
	wp_enqueue_style( 'font-awesome', get_bloginfo( 'stylesheet_directory' ) . '/css/font-awesome.min.css' );
}

// ajout des custom_post_types et des taxonomies
function fg_cheeses_post_type() {
	$labels = array(
		'name'               => __( 'Cheeses', 'divine' ),
		'singular_name'      => __( 'Cheese', 'divine' ),
		'menu_name'          => __( 'Cheeses', 'divine' ),
		'name_admin_bar'     => __( 'Cheeses', 'divine' ),
		'add_new'            => __( 'Add new', 'cheese', 'divine' ),
		'add_new_item'       => __( 'Add new cheese', 'divine' ),
		'new_item'           => __( 'New cheese', 'divine' ),
		'edit_item'          => __( 'Edit cheese', 'divine' ),
		'view_item'          => __( 'View cheese', 'divine' ),
		'all_items'          => __( 'All cheeses', 'divine' ),
		'search_items'       => __( 'Find a cheese', 'divine' ),
		'parent_item_colon'  => __( 'Parent cheeses', 'divine' ),
		'not_found'          => __( 'No cheese find', 'divine' ),
		'not_found_in_trash' => __( 'No cheese in trash', 'divine' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description', 'divine' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'query_var'          => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => get_stylesheet_directory() . "/images/cheese-icon.png",
		'supports'           => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'revisions',
			'page-attributes'
		),
	);
	register_post_type( 'cheese', $args );
}

add_action( 'init', 'fg_cheeses_post_type' );

function fg_kind_of_cheese_taxonomies() {

	$labels = array(
		'name'          => __( 'Kinds of cheese' ),
		'singular_name' => __( 'Kind of cheese' ),
		'search_items'  => __( 'Find all kinds of cheese' ),
		'all_items'     => __( 'All kinds of cheese' ),
		'edit_item'     => __( 'Edit kind of cheese' ),
		'update_item'   => __( 'Modify kind of cheese' ),
		'add_new_item'  => __( 'Add a new kind of cheese' ),
		'new_item_name' => __( 'New kind of cheese name' ),
		'menu_name'     => __( 'Kinds of cheese' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'kinds', array( 'cheese' ), $args );
}

add_action( 'init', 'fg_kind_of_cheese_taxonomies' );

function fg_size_of_cheese_taxonomies() {

	$labels = array(
		'name'          => __( 'Size of cheese' ),
		'singular_name' => __( 'Size of cheese' ),
		'search_items'  => __( 'Find a size of cheese' ),
		'all_items'     => __( 'All sizes of cheese' ),
		'edit_item'     => __( 'Edit a size of cheese' ),
		'update_item'   => __( 'Modify a size of cheese' ),
		'add_new_item'  => __( 'Add a new size of cheese' ),
		'new_item_name' => __( 'Name of the new size of cheese' ),
		'menu_name'     => __( 'Sizes of cheese' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'sizes', array( 'cheese' ), $args );
}

add_action( 'init', 'fg_size_of_cheese_taxonomies' );

function fg_kinds_of_milk_taxonomies() {

	$labels = array(
		'name'          => __( 'Kinds of milk' ),
		'singular_name' => __( 'Kind of milk' ),
		'search_items'  => __( 'Find a kind of milk' ),
		'all_items'     => __( 'All kinds of milk' ),
		'edit_item'     => __( 'Edit a kind of milk' ),
		'update_item'   => __( 'Modify a kind of milk' ),
		'add_new_item'  => __( 'Add a new kind of milk' ),
		'new_item_name' => __( 'Name of the new kind of milk' ),
		'menu_name'     => __( 'Kinds of milk' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'milks', array( 'cheese' ), $args );
}

add_action( 'init', 'fg_kinds_of_milk_taxonomies' );

function fg_intensities_taxonomies() {

	$labels = array(
		'name'          => __( 'Intensities' ),
		'singular_name' => __( 'Intensity' ),
		'search_items'  => __( 'Find a intensity' ),
		'all_items'     => __( 'All intensities' ),
		'edit_item'     => __( 'Edit a intensity' ),
		'update_item'   => __( 'Modify a intensity' ),
		'add_new_item'  => __( 'Add a new intensity' ),
		'new_item_name' => __( 'Name of the new intensity' ),
		'menu_name'     => __( 'Intensities' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'intensities', array( 'cheese' ), $args );
}

add_action( 'init', 'fg_intensities_taxonomies' );

function fg_tastes_taxonomies() {

	$labels = array(
		'name'          => __( 'Tastes' ),
		'singular_name' => __( 'Taste' ),
		'search_items'  => __( 'Find a taste' ),
		'all_items'     => __( 'All tastes' ),
		'edit_item'     => __( 'Edit a taste' ),
		'update_item'   => __( 'Modify a taste' ),
		'add_new_item'  => __( 'Add a new taste' ),
		'new_item_name' => __( 'Name of the new taste' ),
		'menu_name'     => __( 'Tastes' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'tastes', array( 'cheese' ), $args );
}

add_action( 'init', 'fg_tastes_taxonomies' );

function fg_recipes_post_type() {

	$labels = array(
		'name'               => _x( 'Recipes', 'divine' ),
		'singular_name'      => _x( 'Recipe', 'divine' ),
		'menu_name'          => __( 'Recipes', 'divine' ),
		'name_admin_bar'     => __( 'Recipes', 'divine' ),
		'add_new'            => __( 'Add New', 'recipe', 'divine' ),
		'add_new_item'       => __( 'Add New Recipe', 'divine' ),
		'new_item'           => __( 'New Recipe', 'divine' ),
		'edit_item'          => __( 'Edit Recipe', 'divine' ),
		'view_item'          => __( 'View Recipe', 'divine' ),
		'all_items'          => __( 'All Recipes', 'divine' ),
		'search_items'       => __( 'Search Recipes', 'divine' ),
		'parent_item_colon'  => __( 'Parent Recipes', 'divine' ),
		'not_found'          => __( 'No recipes found', 'divine' ),
		'not_found_in_trash' => __( 'No recipes found in Trash', 'divine' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description', 'divine' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'query_var'          => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-carrot',
		'supports'           => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'revisions',
			'page-attributes',
			'comments'
		),
	);

	register_post_type( 'recipe', $args );
}

add_action( 'init', 'fg_recipes_post_type' );

function fg_recipes_cat_taxonomies() {

	$labels = array(
		'name'          => __( 'Recipes categories' ),
		'singular_name' => __( 'Recipe category' ),
		'search_items'  => __( 'Find a recipe category' ),
		'all_items'     => __( 'All recipes categories' ),
		'edit_item'     => __( 'Edit recipe category' ),
		'update_item'   => __( 'Modify recipe category' ),
		'add_new_item'  => __( 'Add a recipe category' ),
		'new_item_name' => __( 'Name of the new recipe category' ),
		'menu_name'     => __( 'Recipes categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'recipes_cat', array( 'recipe' ), $args );
}

add_action( 'init', 'fg_recipes_cat_taxonomies' );


add_action( 'genesis_before_header', 'fg_show_language_selector', 5 );
add_action( 'genesis_before_footer', 'fg_show_language_selector', 5 );

function fg_show_language_selector() {

	$languages = apply_filters( 'wpml_active_languages', null, 'skip_missing=0&orderby=id&order=asc' );

	if ( 1 < count( $languages ) ) {

		foreach ( $languages as $language ) {

			if ( ! $language['active'] ) {
				$langs[] = '<a href="' . $language['url'] . '">' . strtoupper( $language['native_name'] ) . '</a>';
			}
		}

		echo '<div class="language-selector">' . $langs[0] . '</div>';
	}

}

add_action( 'genesis_after_header', 'fg_cheese_background_image_before_entry' );
function fg_cheese_background_image_before_entry() {
	if ( is_post_type_archive( 'cheese' ) ) {

		echo '<img src="' . site_url() . '/wp-content/uploads/2016/01/bandeau-haut-de-page.jpg">';
	}
}

add_action( 'genesis_before_loop', 'cheese_page_description_content' );
function cheese_page_description_content() {
	$html                   = '';
	$display_cheese_content = is_post_type_archive( 'cheese' );

	if ( $display_cheese_content ) {


		$html = '<h1 class="entry-title">' . __( 'Our Cheeses', 'divine' ) . '</h1>';

		echo $html;
	}
}

add_action( 'genesis_entry_header', 'fg_single_product_image', 4 );
function fg_single_product_image() {

	if ( is_singular( 'cheese' ) ) {
		the_post_thumbnail( 'single-cheese-thumb' );

	}
}

add_action( 'genesis_entry_header', 'fg_product_thumbnail', 5 );
function fg_product_thumbnail() {
	if ( is_singular( 'cheese' ) ) {

		if ( get_field( 'cheese_images' ) ) {
			while ( has_sub_field( 'cheese_images' ) ) {

				$image = get_sub_field( 'images' );

				echo '<img src="' . $image['sizes']['thumbnail'] . '">';
			}
		}
	}
}

add_action( 'genesis_entry_content', 'fg_single_product_taxos', 9 );
function fg_single_product_taxos() {
	if ( is_singular( 'cheese' ) ) {

		// section kind of cheese

		$kinds = get_the_terms( get_the_ID(), 'kinds' );
		if ( ! empty( $kinds ) ) {

			foreach ( $kinds as $kind ) {

				echo '<strong>' . $kind->name . '</strong><br>';
			}
			echo '</div><br>';
		}

		// section kind of milk

		$milks = get_the_terms( get_the_ID(), 'milks' );
		if ( ! empty( $milks ) ) {

			foreach ( $milks as $milk ) {

				echo '<strong>' . __( 'Kind of milk : ', 'divine' ) . '</strong>' . $milk->name . '<br>';
			}
		}

		// section intensity

		$intensities = get_the_terms( get_the_ID(), 'intensities' );
		if ( ! empty( $intensities ) ) {

			foreach ( $intensities as $intensitie ) {

				echo '<strong>' . __( 'Intensity : ', 'divine' ) . '</strong>' . $intensitie->name . '<br>';
			}
		}

		// section taste

		$tastes = get_the_terms( get_the_ID(), 'tastes' );
		if ( ! empty( $tastes ) ) {

			$tastes_names_loop   = wp_list_pluck( $tastes, 'name' );
			$tastes_without_link = implode( ", ", $tastes_names_loop );

			echo '<strong>' . __( 'Taste : ', 'divine' ) . '</strong>' . $tastes_without_link;
		}
	}
}

// adding a widget for social icons after single description

genesis_register_sidebar( array(
	'id'          => 'after-single-description-widget',
	'name'        => __( 'After single description widget', 'genesis' ),
	'description' => __( 'Custom widget after single description area', 'divine' ),
) );

add_action( 'genesis_entry_content', 'add_custom_widget_area_after_description', 10 );
function add_custom_widget_area_after_description() {
	genesis_widget_area( 'after-single-description-widget', array(
		'before' => '<div class="after-single-description-widget widget-area">',
		'after'  => '</div>'
	) );
}

add_action( 'genesis_entry_content', 'fg_single_prod_details', 15 );
function fg_single_prod_details() {

	if ( is_singular( 'cheese' ) ) {
		// section awards

		if ( ! empty( have_rows( 'awards' ) ) ) {

			echo '<h2>' . __( 'Awards', 'divine' ) . '</h2>';
			echo '<ul>';

			if ( have_rows( 'awards' ) ) {
				while ( have_rows( 'awards' ) ) {
					the_row();

					$award_logo_link = get_sub_field( 'award_logo' );

					echo '<li><strong>' . esc_html( get_sub_field( 'year' ) ) . '  ' . esc_html( get_sub_field( 'award_category' ) ) . '</strong> ' . esc_html( get_sub_field( 'award_name' ) ) . '<img src="' . $award_logo_link['sizes']['award-pastil-thumb'] . '"></li><br>';
				}
			}
			echo '</ul>';
		}

		// section caracteristics

		$caracteristics = get_field( 'caracteristics' );
		$maturing       = get_field( 'maturing' );
		$sizes          = get_the_terms( get_the_ID(), 'sizes' );
		$fat            = get_field( 'fat' );
		$moisture       = get_field( 'moisture' );

		if ( ! empty( $maturing ) && ! empty( $sizes ) && ! empty( $fat ) && ! empty( $moisture ) ) {

			$sizes_names_loop   = wp_list_pluck( $sizes, 'name' );
			$sizes_without_link = implode( ", ", $sizes_names_loop ); // to separate by a "," each term

			echo '<h2>' . __( 'Caracteristics', 'divine' ) . '</h2>';

			echo '<ul>';
			echo '<li>' . esc_html( $caracteristics ) . '</li>';
			echo '<li><strong>' . __( 'Aging period :', 'divine' ) . '</strong>' . ' ' . esc_html( $maturing ) . '</li>';
			echo '<li><strong>' . __( 'Size(s) : ', 'divine' ) . '</strong>' . ' ' . esc_html( $sizes_without_link ) . '</li>';
			echo '<li><strong>' . __( 'Fat :', 'divine' ) . '</strong>' . ' ' . esc_html( $fat ) . ' %</li>';
			echo '<li><strong>' . __( 'Moisturing :', 'divine' ) . '</strong>' . ' ' . esc_html( $moisture ) . ' %</li>';
			echo '</ul>';
		}

		// section origin

		echo '<h2>' . __( 'Origin', 'divine' ) . '</h2>';

		esc_html( the_field( 'origine' ) );
	}
}

add_action( 'genesis_entry_content', 'fg_single_prod_pairings', 20 );
function fg_single_prod_pairings() {

	if ( is_singular( 'cheese' ) && ! empty( have_rows( 'pairings' ) ) ) {

		echo '<h2>' . __( 'Pairings', 'divine' ) . '</h2>';

		while ( have_rows( 'pairings' ) ) {
			the_row();

			$pastil = get_sub_field( 'image' );

			echo '<h4>' . esc_html( get_sub_field( 'title' ) ) . '</h4>';
			echo '<img src="' . esc_attr( $pastil['url'] ) . '">';
			echo '<strong>' . esc_html( get_sub_field( 'pastil_title' ) ) . '</strong>  ' . esc_html( get_sub_field( 'alcool' ) ) . '<br>';
		}

		echo '<p>' . esc_html__( '* Le choix des pastilles de goût s’harmonisant avec les fromages a été déterminé par les experts de la SAQ. © Société des alcools du Québec, 2007
Les vins que nous suggérons sont disponibles à la SAQ.', 'divine' ) . '</p>';
	}
}

add_action( 'genesis_entry_content', 'fg_single_prod_likes', 25 );
function fg_single_prod_likes() {

	if ( is_singular( 'cheese' ) && ! empty( have_rows( 'likes' ) ) ) {

		echo '<h2>' . __( 'You should like to discover', 'divine' ) . '</h2>';

		while ( has_sub_field( 'likes' ) ) {
			$like_image_link = get_sub_field( 'like_image' );

			echo '<a href="' . esc_html( get_sub_field( 'like_link' ) ) . '"><img src="' . esc_attr( $like_image_link['sizes']['likes-thumb'] ) . '"></a>';
			esc_html( the_sub_field( 'like_title' ) );
		}
	}
}

add_action( 'genesis_before_loop', 'fg_blog_title_before_loop' );
function fg_blog_title_before_loop() {

	if ( is_page( 'nouvelles' ) ) {

		echo '<h1><div class="archive-title">' . __( 'News', 'divine' ) . '</div></h1>';

	}
}

add_action( 'pre_get_posts', 'fg_change_archive_cheese_query' );
/**
 * @param $query WP_Query
 */
function fg_change_archive_cheese_query( $query ) {

	if ( $query->is_main_query() && $query->is_post_type_archive( 'cheese' ) ) {

		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );
	}
}

add_action( 'pre_get_posts', 'fg_change_archive_recipe_query' );
/**
 * @param $query WP_Query
 */
function fg_change_archive_recipe_query( $query ) {

	if ( $query->is_main_query() && $query->is_tax( 'recipes_cat' ) ) {

		$query->set( 'orderby', 'name' ); // what we want to be set by order
		$query->set( 'order', 'ASC' );
	}
}

add_action( 'genesis_entry_content', 'fg_archive_cheese_content' );
function fg_archive_cheese_content() {

	if ( is_post_type_archive( 'cheese' ) ) {

		$cheese_award_pastil = get_field( 'cheese_award_pastil' );

		if ( ! empty( $cheese_award_title ) || ! empty( $cheese_award_pastil ) ) {

			esc_html( the_field( 'cheese_award_title' ) );
			echo '<img src="' . esc_attr( $cheese_award_pastil['sizes']['award-pastil-thumb'] ) . '">';

		}
	}
}

add_action( 'genesis_footer_creds_text', 'fg_logo_footer', 1 );
function fg_logo_footer() {
	echo '<a href="' . home_url() . '"><img src="' . site_url() . '/wp-content/uploads/2016/01/Logo-fromagerie-150x150.jpg"></a>';
}

// to disable default page template on single-"cheese"
add_filter( 'genesis_pre_get_option_site_layout', 'single_cheese_full_width_layout' );
function single_cheese_full_width_layout( $opt ) {
	if ( is_singular( 'cheese' ) ) { // Modify the conditions to apply the layout to here
		$opt = 'full-width-content'; // You can change this to any Genesis layout
		return $opt;
	}
}

add_action( 'genesis_before_loop', 'recipes_categories_menu' );

function recipes_categories_menu() {
	$display_recipes_categories = is_post_type_archive( 'recipe' ) || is_tax( 'recipes_cat' ); // si on est dans les archives du custom post-type 'recipe' OU dans une taxo/catégorie de 'recipes_cat' ( TRUE ou TRUE )

	if ( $display_recipes_categories ) { // si une des 2 conditions est bonne : on affiche le menu de catégorie de recette

		$recipes_cat = get_terms( 'recipes_cat', array( 'hide_empty' => false, 'orderby' => 'ID' ) );

		$html = '<ul class="recipes-cat-menu">';
		foreach ( $recipes_cat as $recipe_cat ) {

			$html .= '<li><a href="' . get_term_link( $recipe_cat ) . '">' . $recipe_cat->name . '</a></li>';
		}
		$html .= '</ul>';

		echo $html;

	}

}

add_action( 'genesis_entry_content', 'fg_recipe_single_content', 2 );
function fg_recipe_single_content() {

	if ( is_singular( 'recipe' ) ) {

		the_post_thumbnail( 'large' );
		esc_html( the_field( 'credit_photo' ) ) ;

	}
}

add_filter('comment_form_defaults' , 'fg_comment_form_filter');
function fg_comment_form_filter($default) {

	$default[ 'title_reply' ] = __( 'Leave a comment', 'divine' );
	$default[ 'label_submit' ] =  __( 'Post', 'divine' );

	$commenter = wp_get_current_commenter();
//	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$default[ 'fields' ][ 'email' ] = '<p class="comment-form-email"><label for="email">' . __( 'Email *', 'divine' ) . '</label> ' .
//	                                  ( $req ? '<span class="required">*</span>' : '' ) .
	                                  '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
	                                  '" size="30"' . $aria_req . ' /></p>';
	return $default;

}