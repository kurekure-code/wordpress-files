<?php
/**
 * Call to action options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add featured section
$wp_customize->add_section( 'pikture_call_to_action_section', array(
	'title'             => esc_html__( 'Call to action','pikture' ),
	'description'       => esc_html__( 'Call to action options works only on Front page.', 'pikture' ),
	'panel'             => 'pikture_front_page_panel',
) );

// Call to action content enable control and setting
$wp_customize->add_setting( 'pikture_theme_options[enable_call_to_action_section]', array(
	'sanitize_callback' => 'pikture_sanitize_switch_control',
	'default'          	=> $options['enable_call_to_action_section'],
) );

$wp_customize->add_control( new Pikture_Switch_Control( $wp_customize, 'pikture_theme_options[enable_call_to_action_section]', array(
	'label'             => esc_html__( 'Call to action Section:', 'pikture' ),
	'section'           => 'pikture_call_to_action_section',
	'on_off_label' 		=> pikture_switch_options(),
) ) );

/**
 * Content Type: Page.
 */
// Call to action content type page control and setting
$wp_customize->add_setting( 'pikture_theme_options[call_to_action_page_id]', array(
	'sanitize_callback' => 'pikture_sanitize_page',
) );

$wp_customize->add_control( 'pikture_theme_options[call_to_action_page_id]', array(
	'label'           => esc_html__( 'Page:', 'pikture' ),
	'description'     => esc_html__( "Title, content, url and image will be used from the selected page's title, trimmed content, permalink and featured image respectively.", 'pikture' ),
	'active_callback' => 'pikture_is_call_to_action_enable',
	'section'         => 'pikture_call_to_action_section',
	'type'            => 'dropdown-pages',
) );