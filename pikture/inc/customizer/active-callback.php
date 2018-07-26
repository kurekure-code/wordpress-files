<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

/**
 * Check if featured content is enabled.
 *
 * @since Pikture 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function pikture_is_featured_content_enable( $control ) {
	return $control->manager->get_setting( 'pikture_theme_options[enable_featured_section]' )->value();
}

/**
 * Check if about section is enabled.
 *
 * @since Pikture 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function pikture_is_about_enable( $control ) {
	return $control->manager->get_setting( 'pikture_theme_options[enable_about_section]' )->value();
}

/**
 * Check if panorama section is enabled.
 *
 * @since Pikture 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function pikture_is_panorama_enable( $control ) {
	return $control->manager->get_setting( 'pikture_theme_options[enable_panorama_section]' )->value();
}

/**
 * Check if call_to_action section is enabled.
 *
 * @since Pikture 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function pikture_is_call_to_action_enable( $control ) {
	return $control->manager->get_setting( 'pikture_theme_options[enable_call_to_action_section]' )->value();
}

/**
 * Check if landscape section is enabled.
 *
 * @since Pikture 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function pikture_is_landscape_enable( $control ) {
	return $control->manager->get_setting( 'pikture_theme_options[enable_landscape_section]' )->value();
}

if ( ! function_exists( 'pikture_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Pikture 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function pikture_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'pikture_theme_options[pagination_enable]' )->value();
	}
endif;

if ( ! function_exists( 'pikture_if_homepage_displays_static_page' ) ) :
	/**
	 * Check if Homepage setting is set to display static page.
	 *
	 * @since Pikture 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function pikture_if_homepage_displays_static_page( $control ) {
		return ( 'page' === get_option( 'show_on_front' ) );
	}
endif;

if ( ! function_exists( 'pikture_if_homepage_displays_latest_posts' ) ) :
	/**
	 * Check if Homepage setting is set to display latest posts.
	 *
	 * @since Pikture 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function pikture_if_homepage_displays_latest_posts( $control ) {
		return ( 'posts' === get_option( 'show_on_front' ) );
	}
endif;