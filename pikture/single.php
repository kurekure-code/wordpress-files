<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

$options = pikture_get_theme_options();

get_header(); ?>

	<div class="container">
		<div class="page-section clear template">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<div class="single-post-wrapper">
							<?php
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/content', 'single' );

								/**
								* Hook pikture_action_post_pagination
								*  
								* @hooked pikture_post_pagination 
								*/
								do_action( 'pikture_action_post_pagination' );
								?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
							?>

					</div><!-- .single-poost-wrapper -->
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php if ( pikture_is_sidebar_enable() ) {
				get_sidebar();
			} ?>
		</div><!-- .page-section -->
	</div><!-- .container -->

<?php
get_footer();
