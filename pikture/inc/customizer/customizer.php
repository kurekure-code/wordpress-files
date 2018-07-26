<?php
/**
 * Pikture Customizer.
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

//load upgrade-to-pro section
require get_template_directory() . '/inc/customizer/upgrade-to-pro/class-customize.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pikture_customize_register( $wp_customize ) {
	$options = pikture_get_theme_options();

	// Load custom control functions.
	require get_template_directory() . '/inc/customizer/custom-controls.php';

	// Load customize active callback functions.
	require get_template_directory() . '/inc/customizer/active-callback.php';

	// Load validation callback functions.
	require get_template_directory() . '/inc/customizer/validation.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	// Header title color setting and control.
	$wp_customize->add_setting( 'pikture_theme_options[header_title_color]', array(
		'default'           => $options['header_title_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pikture_theme_options[header_title_color]', array(
		'priority'			=> 5,
		'label'             => esc_html__( 'Header Title Color', 'pikture' ),
		'section'           => 'colors',
	) ) );

	// Header tagline color setting and control.
	$wp_customize->add_setting( 'pikture_theme_options[header_tagline_color]', array(
		'default'           => $options['header_tagline_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pikture_theme_options[header_tagline_color]', array(
		'priority'			=> 6,
		'label'             => esc_html__( 'Header Tagline Color', 'pikture' ),
		'section'           => 'colors',
	) ) );

	// Site identity extra options.
	$wp_customize->add_setting( 'pikture_theme_options[header_txt_logo_extra]', array(
		'default'           => $options['header_txt_logo_extra'],
		'sanitize_callback' => 'pikture_sanitize_select',
		'transport'			=> 'refresh'
	) );

	$wp_customize->add_control( 'pikture_theme_options[header_txt_logo_extra]', array(
		'priority'			=> 50,
		'type'				=> 'radio',
		'label'             => esc_html__( 'Site Identity Extra Options', 'pikture' ),
		'section'           => 'title_tagline',
		'choices'				=> array( 
			'hide-all'     => esc_html__( 'Hide All', 'pikture' ),
			'show-all'     => esc_html__( 'Show All', 'pikture' ),
			'title-only'   => esc_html__( 'Title Only', 'pikture' ),
			'tagline-only' => esc_html__( 'Tagline Only', 'pikture' ),
			'logo-title'   => esc_html__( 'Logo + Title', 'pikture' ),
			'logo-tagline' => esc_html__( 'Logo + Tagline', 'pikture' ),
			)
	) );

	// Add panel for common theme options
	$wp_customize->add_panel( 'pikture_theme_options_panel' , array(
	    'title'      => esc_html__( 'Theme Options','pikture' ),
	    'description'=> esc_html__( 'Pikture Theme Options.', 'pikture' ),
	    'priority'   => 160,
	) );

	// load layout
	require get_template_directory() . '/inc/customizer/theme-options/layout.php';

	// load static homepage option
	require get_template_directory() . '/inc/customizer/theme-options/homepage-static.php';

	// load archive option
	require get_template_directory() . '/inc/customizer/theme-options/excerpt.php';

	// load archive option
	require get_template_directory() . '/inc/customizer/theme-options/archive.php';
	
	// load pagination option
	require get_template_directory() . '/inc/customizer/theme-options/pagination.php';

	// load footer option
	require get_template_directory() . '/inc/customizer/theme-options/footer.php';

	// Add panel for front page theme options.
	$wp_customize->add_panel( 'pikture_front_page_panel' , array(
	    'title'      => esc_html__( 'Front Page','pikture' ),
	    'description'=> esc_html__( 'Front Page Theme Options.', 'pikture' ),
	    'priority'   => 140,
	) );

	// Load front page sections option
	require get_template_directory() . '/inc/customizer/sections/sections.php';

	/*
	 * Load partial refresh functions.
	 */
	require get_template_directory() . '/inc/customizer/partials.php';
}
add_action( 'customize_register', 'pikture_customize_register' );

/*
 * Load customizer sanitization functions.
 */
require get_template_directory() . '/inc/customizer/sanitize.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function pikture_customize_preview_js() {
	wp_enqueue_script( 'pikture-customizer', get_template_directory_uri() . '/assets/js/customizer' . pikture_min() . '.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'pikture_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function pikture_customize_control_js() {
	wp_enqueue_script( 'jquery-chosen', get_template_directory_uri() . '/assets/js/chosen.jquery' . pikture_min() . '.js', array( 'jquery' ), '1.4.2', true );

	wp_enqueue_script( 'pikture-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls' . pikture_min() . '.js', array(), '1.0.0', true );
	$pikture_cusomizer_control_data = array(
		'reset_message' => esc_html__( 'Refresh the customizer page after saving to view reset effects', 'pikture' ),
		'num_chng_msg' => esc_html__( 'Refresh the customizer page after saving to view effects.', 'pikture' ),
	);
	// Send list of color variables as object to custom customizer js
	wp_localize_script( 'pikture-customize-controls', 'pikture_cusomizer_control_data', $pikture_cusomizer_control_data );


	wp_enqueue_style( 'chosen-css', get_template_directory_uri() . '/assets/css/chosen' . pikture_min() . '.css' );

	wp_enqueue_style( 'customize-controls-css', get_template_directory_uri() . '/assets/css/customize-controls' . pikture_min() . '.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'pikture_customize_control_js' );
