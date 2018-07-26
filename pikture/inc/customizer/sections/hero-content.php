<?php
/**
 * Hero Content options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add hero content section
$wp_customize->add_section( 'pikture_hero_content_section', array(
	'title'             => esc_html__( 'Hero Content','pikture' ),
	'description'       => esc_html__( 'Hero content options. Appears on entire site.', 'pikture' ),
	'panel'             => 'pikture_front_page_panel',
) );

// Hero content text
$wp_customize->add_setting( 'pikture_theme_options[hero_content_text]', array(
	'sanitize_callback' => 'pikture_sanitize_html',
	'default'          	=> $options['hero_content_text'],
	'transport'			=> 'postMessage'
) );

$wp_customize->add_control( 'pikture_theme_options[hero_content_text]', array(
	'label'           => esc_html__( 'Content:', 'pikture' ),
	'description'     => esc_html__( 'HTML Allowed', 'pikture' ),
	'section'         => 'pikture_hero_content_section',
	'type'            => 'textarea',
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'pikture_theme_options[hero_content_text]', array(
		'selector'            => '.header-content h1',
		'render_callback'     => 'pikture_hero_content_text_refresh',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
	) );
}