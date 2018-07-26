<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

get_header(); 
if ( true === apply_filters( 'pikture_filter_frontpage_content_enable', true ) ) : 
?>
	<div class="container">
		<div class="template page-section clear">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<div class="single-post-wrapper">

						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', 'page' );

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
endif;
get_footer();
