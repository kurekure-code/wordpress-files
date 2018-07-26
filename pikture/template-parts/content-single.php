<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

$options = pikture_get_theme_options();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
		<div class="seperator"></div>
	</header><!-- .entry-header -->
	
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="featured-image">
			<?php the_post_thumbnail( 'large' );?>
		</div><!-- .featured-image -->
	<?php endif; ?>
	
	<div class="entry-container">
		
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php pikture_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<div class="entry-content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'pikture' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pikture' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php 

			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'pikture' ) );
			if ( $tags_list ) {
				echo '<span class="tags-links"><span>' . esc_html__( 'Tags: ', 'pikture' ) . '</span>' . $tags_list . '</span>'; // WPCS: XSS OK.
			} 

			?>
			<div class="author-wrapper clear">
			<?php
				// Get the author name; wrap it in a link.
				$byline = sprintf(
					/* translators: %s: post author */
					'%s',
					'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
				);
				
				// Finally, let's write all of this to the page.
				echo get_avatar( get_the_author_meta( 'ID' ) );
				echo '<span class="byline">' . esc_html__( 'Written by', 'pikture' ) . $byline . '</span>';
				?>
			</div>
		</footer><!-- .entry-footer -->

	</div><!-- .entry-container -->
</article><!-- #post-## -->
