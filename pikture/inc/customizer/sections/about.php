<?php
/**
 * About options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add featured section
$wp_customize->add_section( 'pikture_about_section', array(
	'title'             => esc_html__( 'About','pikture' ),
	'description'       => esc_html__( 'About section options works only on Front page. Images with ratio of 2:3 ( for e.g: 640px by 960px ) would look the best in this section.', 'pikture' ),
	'panel'             => 'pikture_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'pikture_theme_options[enable_about_section]', array(
	'sanitize_callback' => 'pikture_sanitize_switch_control',
	'default'          	=> $options['enable_about_section'],
) );

$wp_customize->add_control( new Pikture_Switch_Control( $wp_customize, 'pikture_theme_options[enable_about_section]', array(
	'label'             => esc_html__( 'About Section:', 'pikture' ),
	'section'           => 'pikture_about_section',
	'on_off_label' 		=> pikture_switch_options(),
) ) );

/**
 * Content Type: Page.
 */
// About content type page control and setting
$wp_customize->add_setting( 'pikture_theme_options[about_page_id]', array(
	'sanitize_callback' => 'pikture_sanitize_page',
) );

$wp_customize->add_control( 'pikture_theme_options[about_page_id]', array(
	'label'             => esc_html__( 'Page:', 'pikture' ),
	'description'             => esc_html__( "Title, content, url and image will be used from the selected page's title, trimmed content, permalink and featured image respectively.", 'pikture' ),
	'active_callback' 	=> 'pikture_is_about_enable',
	'section'           => 'pikture_about_section',
	'type'				=> 'dropdown-pages',
) );