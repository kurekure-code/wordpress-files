<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

/**
 * pikture_content_end_action hook
 *
 * @hooked pikture_content_end -  10
 *
 */
do_action( 'pikture_content_end_action' );

/**
 * pikture_content_end_action hook
 *
 * @hooked pikture_footer_start -  10
 * @hooked Pikture_Footer_Widgets->add_footer_widgets -  20
 * @hooked pikture_footer_site_info -  30
 * @hooked pikture_footer_end -  100
 *
 */
do_action( 'pikture_footer' );

/**
 * pikture_page_end_action hook
 *
 * @hooked pikture_page_end -  10
 *
 */
do_action( 'pikture_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
