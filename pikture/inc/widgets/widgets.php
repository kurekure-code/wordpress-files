<?php
/**
 * Pikture widgets inclusion
 *
 * This is the template that includes all custom widgets of Pikture
 *
 * @package Theme Palace
 * @subpackage Theme Palace
 * @since Pikture 1.0.0
 */

/*
 * Add social link widget
 */
require get_template_directory() . '/inc/widgets/social-link-widget.php';

/**
 * Register widgets
 */
function pikture_register_widgets() {

	register_widget( 'Pikture_Social_Link' );
}
add_action( 'widgets_init', 'pikture_register_widgets' );