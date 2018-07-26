<?php
/**
 * Landscape options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add landscape section
$wp_customize->add_section( 'pikture_landscape_section', array(
	'title'             => esc_html__( 'Landscape','pikture' ),
	'description'       => esc_html__( 'Landscape options works only on Front page.', 'pikture' ),
	'panel'             => 'pikture_front_page_panel',
) );

// Landscape content enable control and setting
$wp_customize->add_setting( 'pikture_theme_options[enable_landscape_section]', array(
	'sanitize_callback' => 'pikture_sanitize_switch_control',
	'default'          	=> $options['enable_landscape_section'],
) );

$wp_customize->add_control( new Pikture_Switch_Control( $wp_customize, 'pikture_theme_options[enable_landscape_section]', array(
	'label'             => esc_html__( 'Landscape Section:', 'pikture' ),
	'section'           => 'pikture_landscape_section',
	'on_off_label' 		=> pikture_switch_options(),
) ) );

// Landscape title control and setting
$wp_customize->add_setting( 'pikture_theme_options[landscape_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'          	=> $options['landscape_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'pikture_theme_options[landscape_title]', array(
	'label'             => esc_html__( 'Title:', 'pikture' ),
	'section'           => 'pikture_landscape_section',
	'active_callback' 	=> 'pikture_is_landscape_enable',
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'pikture_theme_options[landscape_title]', array(
		'selector'            => '#landscape .entry-title',
		'render_callback'     => 'pikture_landscape_title',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
	) );
}

/**
 * Content type: Category.
 */
// Landscape gallery control and setting
$wp_customize->add_setting( 'pikture_theme_options[landscape_category]', array(
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Pikture_Dropdown_Category_Control( $wp_customize, 'pikture_theme_options[landscape_category]', array(
	'label'           => esc_html__( 'Category:', 'pikture' ),
	'description'     => esc_html__( "Image and url will be used from the selected category's recent posts' featured image and permalink respectively.", 'pikture' ),
	'section'         => 'pikture_landscape_section',
	'active_callback' => 'pikture_is_landscape_enable',
	'multiple'        => false,
) ) );
