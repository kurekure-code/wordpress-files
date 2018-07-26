<?php 

/**
 * Customizer Partial Functions
 *
 * @package Theme_Palace
 * @subpackage Pikture
 * @since 1.0
 */

if ( ! function_exists( 'pikture_hero_content_text_refresh' ) ) :
	/**
	 * Render hero content text for the selective refresh partial.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function pikture_hero_content_text_refresh() {
		$options = pikture_get_theme_options();
		return wp_kses_post( $options['hero_content_text'] );
	}
endif;

if ( ! function_exists( 'pikture_panorama_title' ) ) :
	/**
	 * Render panorama title text selective refresh partial.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function pikture_panorama_title() {
		$options = pikture_get_theme_options();
		return esc_html( $options['panorama_title'] );
	}
endif;

if ( ! function_exists( 'pikture_landscape_title' ) ) :
	/**
	 * Render landscape title text selective refresh partial.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function pikture_landscape_title() {
		$options = pikture_get_theme_options();
		return esc_html( $options['landscape_title'] );
	}
endif;

if ( ! function_exists( 'pikture_copyright_text_refresh' ) ) :
	/**
	 * Render copyright text selective refresh partial.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function pikture_copyright_text_refresh() {
		$options = pikture_get_theme_options();
		return wp_kses_post( $options['copyright_text'] );
	}
endif;

if ( ! function_exists( 'pikture_panorama_your_latest_posts_title' ) ) :
	/**
	 * Render homepage displayed latest post title
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function pikture_panorama_your_latest_posts_title() {
		$options = pikture_get_theme_options();
		return wp_kses_post( $options['your_latest_posts_title'] );
	}
endif;