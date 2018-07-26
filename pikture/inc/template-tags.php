<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

if ( ! function_exists( 'pikture_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function pikture_posted_on() {
	$options = pikture_get_theme_options();
	
	// Get the author name; wrap it in a link.
	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>';

	if ( ( is_archive() || is_home() ) || ( is_singular( 'post' ) ) ) {
		// Finally, let's write all of this to the page.
		echo '<span class="posted-on">' . pikture_time_link() . '</span>';
	}

	if ( ( is_archive() || is_home() ) || ( is_singular( 'post' ) ) ) {
		echo '<span class="byline"> ' . $byline . '</span>';
	}

	if ( is_single() ) {
		echo '<span class="cat-links">';
		$categories_list = get_the_category_list( esc_html__( ', ', 'pikture' ) );
		if ( $categories_list && pikture_categorized_blog() ) {
			echo  $categories_list; // WPCS: XSS OK.
		}
		echo '</span>';
	}

}
endif;


if ( ! function_exists( 'pikture_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function pikture_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf(
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'pikture' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;

if ( ! function_exists( 'pikture_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function pikture_entry_footer() {
		$options = pikture_get_theme_options();
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			if ( ( is_archive() || is_home() ) ) {
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html__( ', ', 'pikture' ) );
				if ( $tags_list ) {
					printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s ', 'pikture' ) . '</span>', $tags_list ); // WPCS: XSS OK.
				}
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'pikture' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( ' Edit %s', 'pikture' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function pikture_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'pikture_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'pikture_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so pikture_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so pikture_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in pikture_categorized_blog.
 */
function pikture_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'pikture_categories' );
}
add_action( 'edit_category', 'pikture_category_transient_flusher' );
add_action( 'save_post',     'pikture_category_transient_flusher' );
