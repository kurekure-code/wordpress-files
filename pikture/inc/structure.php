<?php
/**
 * Pikture basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

$options = pikture_get_theme_options();


if ( ! function_exists( 'pikture_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Pikture 1.0.0
	 */
	function pikture_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;

add_action( 'pikture_doctype', 'pikture_doctype', 10 );


if ( ! function_exists( 'pikture_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif;
	}
endif;
add_action( 'pikture_before_wp_head', 'pikture_head', 10 );

if ( ! function_exists( 'pikture_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'pikture' ); ?></a>

		<?php
	}
endif;

add_action( 'pikture_page_start_action', 'pikture_page_start', 10 );

if ( ! function_exists( 'pikture_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'pikture_page_end_action', 'pikture_page_end', 10 );

if ( ! function_exists( 'pikture_header_start' ) ) :
	/**
	 * Header start html codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_header_start() {
		?>
		<header id="masthead" class="site-header" role="banner">
            <div class="container">
		<?php
	}
endif;
add_action( 'pikture_header_action', 'pikture_header_start', 10 );

if ( ! function_exists( 'pikture_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_site_branding() {
		$options  = pikture_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];		
		?>
		<div class="site-branding">

			<div class="site-logo">
				<?php 
				if ( 'show-all' === $header_txt_logo_extra || 'logo-title' === $header_txt_logo_extra || 'logo-tagline' === $header_txt_logo_extra ) {
					the_custom_logo();
				}
				?> 
			</div><!-- .site-logo -->

			<div class="site-details">
				<?php
				if( 'show-all' === $header_txt_logo_extra  || 'title-only' === $header_txt_logo_extra || 'logo-title' === $header_txt_logo_extra ) {
					if ( pikture_is_latest_posts() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;
				} 
				if ( 'show-all' === $header_txt_logo_extra  || 'tagline-only' === $header_txt_logo_extra || 'logo-tagline' === $header_txt_logo_extra ) {
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
					endif; 
				}?>
			</div><!-- .site-details -->
			
		</div><!-- .site-branding -->
		<?php
	}
endif;
add_action( 'pikture_header_action', 'pikture_site_branding', 20 );

if ( ! function_exists( 'pikture_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_site_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="search-icons">
				<?php 
					echo pikture_get_svg( array( 'icon' => 'close' ) );
				 ?>
			</button>
			
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<?php
					echo pikture_get_svg( array( 'icon' => 'bars' ) );
					echo pikture_get_svg( array( 'icon' => 'close' ) );
				?>	
			</button>

			<?php wp_nav_menu( array( 
				'fallback_cb'=>'pikture_menu_fallback_cb', 
				'theme_location' => 'primary', 
				'menu_id' => 'primary-menu' 
			) ); ?>
		</nav><!-- #site-navigation -->
		<?php
	}
endif;
add_action( 'pikture_header_action', 'pikture_site_navigation', 30 );


/**
 * Add dropdown icon if menu item has children.
 *
 * @param  string $title The menu item's title.
 * @param  object $item  The current menu item.
 * @param  array  $args  An array of wp_nav_menu() arguments.
 * @param  int    $depth Depth of menu item. Used for padding.
 * @return string $title The menu item's title with dropdown icon.
 */
function pikture_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
	$options  = pikture_get_theme_options();
	if ( 'primary' === $args->theme_location ) {
		foreach ( $item->classes as $value ) {
			if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
				$title = $title . pikture_get_svg( array( 'icon' => 'angle-down' ) );
			}
		}
	}

	return $title;
}
add_filter( 'nav_menu_item_title', 'pikture_dropdown_icon_to_menu_link', 10, 4 );

if ( ! function_exists( 'pikture_header_end' ) ) :
	/**
	 * Header end html codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_header_end() {
		?>
			</div>
		</header><!-- #masthead -->
		
		<?php 
		$options  = pikture_get_theme_options();
		$hero_content_text = $options['hero_content_text']; 
		if (  ! empty( $hero_content_text ) ) : ?>
			<div class="header-content">
			    <h1><?php echo wp_kses_post( $hero_content_text ); ?></h1>
			</div><!-- .header-content -->
		<?php endif; ?>
		<?php
	}
endif;

add_action( 'pikture_header_action', 'pikture_header_end', 50 );

if ( ! function_exists( 'pikture_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'pikture_content_start_action', 'pikture_content_start', 10 );

if ( ! function_exists( 'pikture_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_content_end() {
		?>
		</div><!-- #content -->
		<?php
	}
endif;
add_action( 'pikture_content_end_action', 'pikture_content_end', 10 );

if ( ! function_exists( 'pikture_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
            	<div class="inner-wrapper">
		<?php
	}
endif;
add_action( 'pikture_footer', 'pikture_footer_start', 10 );

if ( ! function_exists( 'pikture_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Theme Palace 1.0
	 *
	 */
	function pikture_footer_site_info() {
		$options  = pikture_get_theme_options();

		$copyright_text = ( isset( $options['copyright_text'] ) ) ? $options['copyright_text'] : '' ;

		$col_class = 'col-1';
		if ( has_nav_menu( 'social' ) && $copyright_text ) {
			$col_class = 'col-2';
		}
		?>
		<div class="site-info <?php echo esc_attr( $col_class ); ?>">
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<div class="hentry">
					<div class="social-icons">
						<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'pikture' ); ?>">
							<?php
								wp_nav_menu( array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . pikture_get_svg( array( 'icon' => 'chain' ) ),
								) );
							?>
						</nav><!-- .social-navigation -->
					</div>
				</div>
			<?php endif;

			if ( $copyright_text ) : ?>
				<div class="hentry copyright">
					<?php echo wp_kses_post( $copyright_text ); 
					if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link( '<span> | </span>' );
					}
					?>
				</div><!-- .pull-left -->
			<?php endif; ?>
		</div><!-- .site-info -->
		<?php
	}
endif;
add_action( 'pikture_footer', 'pikture_footer_site_info', 40 );

if ( ! function_exists( 'pikture_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_footer_scroll_to_top() {
		$options  = pikture_get_theme_options();
		if ( true === $options['scroll_top_visible'] ) : ?>
			<div class="backtotop"><?php echo pikture_get_svg( array( 'icon' => 'angle-down' ) ); ?></div>
		<?php endif;
	}
endif;
add_action( 'pikture_footer', 'pikture_footer_scroll_to_top', 30 );

if ( ! function_exists( 'pikture_footer_end' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Pikture 1.0.0
	 *
	 */
	function pikture_footer_end() {
		?>
				</div><!-- .inner-wrapper -->
			</div><!-- .container -->
		</footer>
		<?php
	}
endif;
add_action( 'pikture_footer', 'pikture_footer_end', 100 );