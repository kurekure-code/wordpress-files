<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

get_header(); 

$options  = pikture_get_theme_options();
?>
<div class="container page-section clear">
		<header class="page-header">
				<h2 class="page-title entry-title">
					<?php if ( is_home() && ! is_front_page() ) :
						single_post_title();
					else :
						echo esc_html( $options['your_latest_posts_title'] );
					endif; ?>
				</h2>
				<div class="seperator"></div>
		</header>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="archive-blog-wrapper">
					<?php

					if ( have_posts() ) :


						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );

						endwhile;

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif; 
					?>
				
				<?php
				/**
				* Hook - pikture_action_pagination.
				*
				* @hooked pikture_pagination 
				*/
				do_action( 'pikture_action_pagination' ); 
				?>

			</div><!-- .archive-blog-wrapper -->
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php if ( pikture_is_sidebar_enable() ) :
		get_sidebar();
	endif; ?>
	
</div><!-- .container -->
<?php
get_footer();
