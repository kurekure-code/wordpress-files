<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'pikture_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'pikture' ),
		'priority'   			=> 900,
		'panel'      			=> 'pikture_theme_options_panel',
	)
);

// Footer text
$wp_customize->add_setting( 'pikture_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'pikture_santize_allow_tag',
		'transport'				=> 'postMessage'
	)
);

$wp_customize->add_control( 'pikture_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Footer Text', 'pikture' ),
		'description'      			=> esc_html__( 'HTML Allowed.', 'pikture' ),
		'section'    			=> 'pikture_section_footer',
		'type'		 			=> 'textarea',
    )
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'pikture_theme_options[copyright_text]', array(
		'selector'            => '#colophon .copyright',
		'render_callback'     => 'pikture_copyright_text_refresh',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
	) );
}

// scroll top visible
$wp_customize->add_setting( 'pikture_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'pikture_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Pikture_Switch_Control( $wp_customize, 'pikture_theme_options[scroll_top_visible]',
    array(
		'label'        => esc_html__( 'Display Scroll Top Button', 'pikture' ),
		'section'      => 'pikture_section_footer',
		'on_off_label' => pikture_switch_options(),
    )
) );