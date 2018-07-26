<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Wedlock
 */

if ( ! function_exists( 'wedlock_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wedlock_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'wedlock' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'wedlock' ) );
	
	echo '<span class="posted-on">' . $posted_on . '</span> - '; // WPCS: XSS OK.
	if ( $categories_list && wedlock_categorized_blog() ) {
		printf( '<span class="cat-links">' . esc_html__( '%1$s', 'wedlock' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'wedlock_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wedlock_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'wedlock' ) );
		if ( is_single() ) {
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'wedlock' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}
	if ( is_single() ) {
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'wedlock' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link row">',
			'</span>'
		);
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wedlock_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wedlock_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wedlock_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wedlock_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wedlock_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in wedlock_categorized_blog.
 */
function wedlock_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'wedlock_categories' );
}
add_action( 'edit_category', 'wedlock_category_transient_flusher' );
add_action( 'save_post',     'wedlock_category_transient_flusher' );

/**
 * Output custom logo.
 */
function wedlock_the_custom_logo() {
	
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}