<?php
/**
 * Panorama options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add featured section
$wp_customize->add_section( 'pikture_panorama_section', array(
	'title'             => esc_html__( 'Panorama','pikture' ),
	'description'       => esc_html__( 'Panorama options works only on Front page.', 'pikture' ),
	'panel'             => 'pikture_front_page_panel',
) );

// Panorama content enable control and setting
$wp_customize->add_setting( 'pikture_theme_options[enable_panorama_section]', array(
	'sanitize_callback' => 'pikture_sanitize_switch_control',
	'default'          	=> $options['enable_panorama_section'],
) );

$wp_customize->add_control( new Pikture_Switch_Control( $wp_customize, 'pikture_theme_options[enable_panorama_section]', array(
	'label'             => esc_html__( 'Panorama Section:', 'pikture' ),
	'section'           => 'pikture_panorama_section',
	'on_off_label' 		=> pikture_switch_options(),
) ) );

// Panorama title control and setting
$wp_customize->add_setting( 'pikture_theme_options[panorama_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'          	=> $options['panorama_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'pikture_theme_options[panorama_title]', array(
	'label'             => esc_html__( 'Title:', 'pikture' ),
	'section'           => 'pikture_panorama_section',
	'active_callback' 	=> 'pikture_is_panorama_enable',
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'pikture_theme_options[panorama_title]', array(
		'selector'            => '#panorama .entry-title',
		'render_callback'     => 'pikture_panorama_title',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
	) );
}

/**
 * Content type: Category.
 */
// Panorama gallery control and setting
$wp_customize->add_setting( 'pikture_theme_options[panorama_category]', array(
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Pikture_Dropdown_Category_Control( $wp_customize, 'pikture_theme_options[panorama_category]', array(
	'label'           => esc_html__( 'Category:', 'pikture' ),
	'description'     => esc_html__( "Image and url will be used from the selected category's recent posts' featured image and permalink respectively.", 'pikture' ),
	'section'         => 'pikture_panorama_section',
	'active_callback' => 'pikture_is_panorama_enable',
	'multiple'        => false,
) ) );