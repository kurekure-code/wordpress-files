<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Pikture
* @since Pikture 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'pikture_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'pikture_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'pikture_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'pikture' ),
	'description' 	=> esc_html__( 'Check to display Homepage\'s content.', 'pikture' ),
	'section'     	=> 'static_front_page',
	'active_callback'   => 'pikture_if_homepage_displays_static_page',
	'type'        	=> 'checkbox',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'pikture_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'pikture_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'pikture' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'pikture' ),
	'section'           => 'static_front_page',
	'type'				=> 'text',
	'active_callback'   => 'pikture_if_homepage_displays_latest_posts'
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'pikture_theme_options[your_latest_posts_title]', array(
		'selector'            => '.home.blog .page-header .page-title',
		'render_callback'     => 'pikture_panorama_your_latest_posts_title',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
	) );
}