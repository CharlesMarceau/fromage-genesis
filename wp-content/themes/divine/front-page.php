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

add_action( 'genesis_meta', 'divine_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function divine_home_genesis_meta() {

	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-triple-bottom' ) || is_active_sidebar( 'home-double-bottom' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'divine_home_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
		add_filter( 'body_class', 'divine_add_home_body_class' );

	}

}

function divine_home_sections() {

	genesis_widget_area( 'home-slider', array(
		'before' => '<div class="home-slider widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );

	if ( is_active_sidebar( 'home-triple-bottom' ) || is_active_sidebar( 'home-double-bottom' ) ) {

		echo '<div class="home-bottom">';

		genesis_widget_area( 'home-triple-bottom', array(
			'before' => '<div class="home-triple-bottom widget-area">',
			'after'  => '</div>',
		) );

		genesis_widget_area( 'home-double-bottom', array(
			'before' => '<div class="home-double-bottom widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';

	}

	genesis_do_loop();

}

//* Add body class to home page		
function divine_add_home_body_class( $classes ) {

	$classes[] = 'divine-home';

	return $classes;

}

//////////////////////////////
//                          //
// CUSTOM FROMAGERIES GRUES //
//                          //
//////////////////////////////

add_action( 'genesis_before_content', 'fg_front_page_top', 10 );
function fg_front_page_top() {
	if ( is_front_page() ) {

		$top_left_image  = get_field( 'image_1' );
		$top_right_image = get_field( 'image_3' );
		$award_split     = get_field( 'split' );

		if ( ! empty( get_field( 'title_1' ) ) ) {

			esc_html( the_field( 'title_1' ) );
			echo '<a href="' . esc_attr( get_field( 'link_1' ) ) . '"><img src="' . esc_attr( $top_left_image['sizes']['homeslider-thumb'] ) . '"></a>';
		}

		if ( have_rows( 'middle_slider' ) ) {
			while ( have_rows( 'middle_slider' ) ) {

				the_row();

				$slider_image = get_sub_field( 'slider_image' );

				esc_html( the_sub_field( 'slider_title' ) );
				echo '<a href="' . esc_attr( get_sub_field( 'link' ) ) . '"><img src="' . esc_attr( $slider_image['sizes']['homeslider-thumb'] ) . '"></a>';
			}
		}

		if ( ! empty( get_field( 'title_3' ) ) ) {

			esc_html( the_field( 'title_3' ) );
			echo '<a href="' . esc_attr( get_field( 'link_3' ) ) . '"><img src="' . esc_attr( $top_right_image['sizes']['homeslider-thumb'] ) . '"></a>';
		}

		echo '<h2 class="entry-title">' . __( "Our cheeses honored", "divine" ) . '</h2>';
		echo '<div class="awards-separator"><img src="' . $award_split['url'] . '"></div>';

	}
}

add_action( 'genesis_before_loop', 'fg_front_after_awards', 10 );
function fg_front_after_awards() {

	echo '<h3>' . __( 'Awards', 'divine' ) . '</h3>';

	if ( have_rows( 'cheese_award' ) ) {

		while ( have_rows( 'cheese_award' ) ) {
			the_row();

			$award_cheese_image = get_sub_field( 'award_cheese_image' );
			$award_cheese_link  = get_sub_field( 'award_cheese_link' );

			echo esc_html( the_sub_field( 'award_cheese_name' ) );
			echo '<a href="' . esc_attr( $award_cheese_link ) . '"><img src="' . esc_attr( $award_cheese_image['sizes']['award-thumb'] ) . '"></a>';

		}
	}
}

add_action( 'genesis_entry_content', 'fg_events_section', 5 );
function fg_events_section() {

	$today_date  = date( 'Y-m-d' );
	$event_check = get_field( 'event_check' );
	$events      = new WP_Query
	( array(
		'post_type'      => 'post',
		'tax_query'      => array(
			'taxonomy' => 'evenements'
		),
		'posts_per_page' => 3,
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'event_date',
				'compare' => '>=',
				'value'   => $today_date,
				'type'    => 'DATE',
			),
			array(
				'key'     => 'event_check',
				'compare' => '==',
				'value'   => 1, // TRUE
			),
		),
	) );

	echo '<h3>' . __( 'Our events', 'divine' ) . '</h3>';

	if ( $events->have_posts() ) {
		while ( $events->have_posts() ) {
			$events->the_post();

			$event_date         = get_field( 'event_date' );
			$event_localisation = get_field( 'event_localisation' );
			$y                  = substr( $event_date, 0, 4 );
			$m                  = substr( $event_date, 4, 2 );
			$d                  = substr( $event_date, 6, 2 );

			$time = strtotime( "{$d}-{$m}-{$y}" );

			echo date( 'd-m', $time ) . '<br>';
			the_title();
			echo '<br>' . $event_localisation . '<br>';
			echo date( 'd F Y', $time ) . '<br>';

			the_post_thumbnail( 'event-thumb' );
			$content = get_the_content();
			echo substr( $content, 0, 100 );
			echo '<a href="' . get_the_permalink() . '">...En savoir plus[...]</a><br><br>';
		}
	}
	wp_reset_query();
}

add_action( 'genesis_entry_content', 'fg_artisanal_section', 8 );
function fg_artisanal_section() {

	if ( have_rows( 'artisanal_section' ) ) {

		echo '<h3>' . __( 'Distinct artisan cheeses', 'divine' ) . '</h3>';

		while ( have_rows( 'artisanal_section' ) ) {

			the_row();

			esc_html( the_sub_field( 'artisanal_title' ) );
			$artisanal_image = get_sub_field( 'artisanal_image' );
			echo '<a href="#"><img src="' . esc_attr( $artisanal_image['sizes']['third-thumb'] ) . '"></a>';

			$content = esc_html( get_sub_field( 'artisanal_description' ) );
			echo substr( $content, 0, 250 ) . '<br>';
		}
	}
}

add_action( 'genesis_entry_content', 'fg_content_section', 9 );
function fg_content_section() {

	echo '<h2>' . __( "100&#37; ownership by producers", "divine" ) . '</h2>';
}

genesis();
