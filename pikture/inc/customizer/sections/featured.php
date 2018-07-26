<?php
/**
 * Featured options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

// Add featured section
$wp_customize->add_section( 'pikture_featured_section', array(
	'title'             => esc_html__( 'Featured','pikture' ),
	'description'       => esc_html__( 'Featured options works only on Front page. Images with ratio of 2:3 ( for e.g: 640px by 960px ) would look the best in this section.', 'pikture' ),
	'panel'             => 'pikture_front_page_panel',
) );

// Featured content enable control and setting
$wp_customize->add_setting( 'pikture_theme_options[enable_featured_section]', array(
	'sanitize_callback' => 'pikture_sanitize_switch_control',
	'default'          	=> $options['enable_featured_section'],
) );

$wp_customize->add_control( new Pikture_Switch_Control( $wp_customize, 'pikture_theme_options[enable_featured_section]', array(
	'label'             => esc_html__( 'Featured Section:', 'pikture' ),
	'section'           => 'pikture_featured_section',
	'on_off_label' 		=> pikture_switch_options(),
) ) );

for ( $i=1; $i < 4; $i++ ) { 
	/**
	 * Content type: Post.
	 */
	// Featured content type post control and setting
	$wp_customize->add_setting( 'pikture_theme_options[featured_post_id_'.$i.']', array(
		'sanitize_callback' => 'pikture_sanitize_page',
	) );

	$wp_customize->add_control( new Pikture_Dropdown_Chooser( $wp_customize, 'pikture_theme_options[featured_post_id_'.$i.']', array(
		'label'             => esc_html__( 'Post ', 'pikture' ) . $i,
		'description'             => esc_html__( "Image and url will be used from the selected post's featured image and permalink respectively.", 'pikture' ),
		'active_callback' 	=> 'pikture_is_featured_content_enable',
		'section'           => 'pikture_featured_section',
		'choices'         => pikture_posts_choices(),
	) ) );
}