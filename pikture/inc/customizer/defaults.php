<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 * @return array An array of default values
 */

function pikture_get_default_theme_options() {
	$theme_data = wp_get_theme();
	$pikture_default_options = array(
		/**
		 * Front page options
		 */
		// Hero Content Options
		'hero_content_text'                     => sprintf( esc_html__( '... because every picture tells a %1$sstory,%2$s too much %1$sperfection%2$s is mistake...', 'pikture' ), '<i>', '</i>' ),
		
		// Featured content options
		'enable_featured_section'               => true,
		
		// About options
		'enable_about_section'                  => true,
		
		// Panorama options
		'enable_panorama_section'               => true,
		'panorama_title'                        => esc_html__( 'Panorama', 'pikture' ),

		// Call to action options
		'enable_call_to_action_section'         => true,
		
		// Landscape options
		'enable_landscape_section'              => true,
		'landscape_title'                        => esc_html__( 'Landscape', 'pikture' ),
		
		/**
		* Theme options
		*/
		// Color Options
		'header_title_color'                    => '#000',
		'header_tagline_color'                  => '#000',
		'header_txt_logo_extra'                 => 'show-all',
		
		// layout 
		'sidebar_position'                      => 'right-sidebar',
		'post_sidebar_position'                 => 'right-sidebar',
		'page_sidebar_position'                 => 'right-sidebar',
		
		// excerpt options
		'long_excerpt_length'                   => 25,
		'read_more_text'                        => esc_html__( 'Read More', 'pikture' ),
		
		// pagination options
		'pagination_enable'                     => true,
		'pagination_type'                       => 'default',
		
		// footer options
		'copyright_text'                        => sprintf( esc_html_x( 'Copyright &copy; %1$s', '1: Year', 'pikture' ), date_i18n( __( 'Y', 'pikture' ) ) ) . ' &#124; ' . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . __( 'by', 'pikture' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>',
		'scroll_top_visible'                    => true,
		
		// homepage options
		'enable_frontpage_content'              => false,
		
		// blog/archive options
		'your_latest_posts_title'               => esc_html__( 'Blogs', 'pikture' ),
		'archive_content_type'                  => 'excerpt',
	);

	$output = apply_filters( 'pikture_default_theme_options', $pikture_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}