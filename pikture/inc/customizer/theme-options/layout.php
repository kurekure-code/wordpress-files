<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'pikture_layout', array(
	'title'               => esc_html__('Layout','pikture'),
	'description'         => esc_html__( 'Layout section options.', 'pikture' ),
	'panel'               => 'pikture_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'pikture_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'pikture_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Pikture_Custom_Radio_Image_Control ( $wp_customize, 'pikture_theme_options[sidebar_position]', array(
	'label'       => esc_html__( 'Global Sidebar Position', 'pikture' ),
	'description' => esc_html__( 'This will affect all other layouts like search page, 404 page except for pages and posts.', 'pikture' ),
	'section'     => 'pikture_layout',
	'choices'     => pikture_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'pikture_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'pikture_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Pikture_Custom_Radio_Image_Control ( $wp_customize, 'pikture_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'pikture' ),
	'section'             => 'pikture_layout',
	'choices'			  => pikture_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'pikture_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'pikture_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Pikture_Custom_Radio_Image_Control( $wp_customize, 'pikture_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'pikture' ),
	'section'             => 'pikture_layout',
	'choices'			  => pikture_sidebar_position(),
) ) );