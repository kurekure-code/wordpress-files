<?php
/**
 * Load all the front page sections' options.
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

/**
 * Frontpage sortable options
 *
 */

// Include hero content.
require get_template_directory() . '/inc/customizer/sections/hero-content.php';

// Include featured section.
require get_template_directory() . '/inc/customizer/sections/featured.php';

// Include about section.
require get_template_directory() . '/inc/customizer/sections/about.php';

// Include panorama section.
require get_template_directory() . '/inc/customizer/sections/panorama.php';

// Include call to action section.
require get_template_directory() . '/inc/customizer/sections/call-to-action.php';

// Include landscape section.
require get_template_directory() . '/inc/customizer/sections/landscape.php';
