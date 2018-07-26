<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'pikture_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','pikture' ),
	'description'       => esc_html__( 'These options works on archives like: search, blog, date archive and so on.', 'pikture' ),
	'panel'             => 'pikture_theme_options_panel',
) );

// Show archive content type setting and control.
$wp_customize->add_setting( 'pikture_theme_options[archive_content_type]', array(
	'default'           => $options['archive_content_type'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'pikture_theme_options[archive_content_type]', array(
	'label'             => esc_html__( 'Archive Content', 'pikture' ),
	'section'           => 'pikture_archive_section',
	'type'				=> 'radio',
	'choices'			=> array( 
		'excerpt' => esc_html__( 'Excerpt', 'pikture' ),
		'content' => esc_html__( 'Full Content', 'pikture' )
	),
) );