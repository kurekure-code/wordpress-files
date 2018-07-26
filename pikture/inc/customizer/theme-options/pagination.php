<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'pikture_pagination', array(
	'title'               => esc_html__('Pagination','pikture'),
	'description'         => esc_html__( 'Pagination section options.', 'pikture' ),
	'panel'               => 'pikture_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'pikture_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'pikture_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Pikture_Switch_Control( $wp_customize, 'pikture_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'pikture' ),
	'section'             => 'pikture_pagination',
	'on_off_label' 		=> pikture_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'pikture_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'pikture_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'pikture_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'pikture' ),
	'section'             => 'pikture_pagination',
	'type'                => 'select',
	'choices'			  => pikture_pagination_options(),
	'active_callback'	  => 'pikture_is_pagination_enable',
) );
