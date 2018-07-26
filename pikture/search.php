<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

get_header(); ?>

	<div class="container page-section clear">
		<section id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<div class="archive-blog-wrapper">
					<?php
					if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'pikture' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header><!-- .page-header -->
						
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content' );

						endwhile;

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif; 

					/**
					* Hook - pikture_action_pagination.
					*
					* @hooked pikture_pagination 
					*/
					do_action( 'pikture_action_pagination' ); 
					?>

				</div><!-- .archive-blog-wrapper -->
			</main><!-- #main -->
		</section><!-- #primary -->
		<?php if ( pikture_is_sidebar_enable() ) {
			get_sidebar();
		} ?>
	</div><!-- .container -->	

<?php

get_footer();
