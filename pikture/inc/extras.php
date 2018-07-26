<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function pikture_body_classes( $classes ) {
	$options = pikture_get_theme_options();

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add a class for sidebar
	$sidebar_position = pikture_layout();

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = esc_attr( $sidebar_position );
	} else {
		$classes[] = 'no-sidebar';
	}

	$classes[] = 'modern-menu';

	return $classes;
}
add_filter( 'body_class', 'pikture_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function pikture_post_classes( $classes ) {
	$options = pikture_get_theme_options();
	
	if ( ! has_post_thumbnail() ) {
		$classes[] = 'has-no-post-thumbnail';
		if ( in_array('has-post-thumbnail', $classes ) ) {
		    unset( $classes[ array_search( 'has-post-thumbnail', $classes ) ] );
		}
	}

	return $classes;
}
add_filter( 'post_class', 'pikture_post_classes' );