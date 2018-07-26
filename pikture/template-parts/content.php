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
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="featured-image" style="background-image: url( '<?php the_post_thumbnail_url();?>' );">
		</div><!-- .featured-image -->
	<?php endif; ?>
	<div class="entry-container">
		<header class="entry-header">
				<?php
					echo '<span class="cat-links">';
					$categories_list = get_the_category_list( esc_html__( ', ', 'pikture' ) );
					if ( $categories_list && pikture_categorized_blog() ) {
						echo  $categories_list; // WPCS: XSS OK.
					}
					echo '</span>';
				?>
			<?php

			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php
			if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php pikture_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

			<div class="entry-content">
				<?php
					if ( 'excerpt' === $options['archive_content_type'] ) :
						the_excerpt();
					else :
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pikture' ),
							'after'  => '</div>',
						) );
					endif;

				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php pikture_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div><!-- .entry-summary -->
	</div><!-- .entry-container -->
</article><!-- #post-## -->
