<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Pikture
	 * @since Pikture 1.0.0
	 */

	/**
	 * pikture_doctype hook
	 *
	 * @hooked pikture_doctype -  10
	 *
	 */
	do_action( 'pikture_doctype' );

?>
<head>
<?php
	/**
	 * pikture_before_wp_head hook
	 *
	 * @hooked pikture_head -  10
	 *
	 */
	do_action( 'pikture_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
<?php
	/**
	 * pikture_page_start_action hook
	 *
	 * @hooked pikture_page_start -  10
	 *
	 */
	do_action( 'pikture_page_start_action' ); 

	/**
	 * pikture_loader_action hook
	 *
	 * @hooked pikture_loader -  10
	 *
	 */
	do_action( 'pikture_before_header' );

	/**
	 * pikture_header_action hook
	 *
	 * @hooked pikture_header_start -  10
	 * @hooked pikture_site_branding -  20
	 * @hooked pikture_site_navigation -  30
	 * @hooked pikture_header_end -  50
	 *
	 */
	do_action( 'pikture_header_action' );

	/**
	 * pikture_content_start_action hook
	 *
	 * @hooked pikture_content_start -  10
	 *
	 */
	
	do_action( 'pikture_content_start_action' );

	/**
	* pikture_primary_content hook
	*
	* @hooked pikture_home_page_sections - 20
	*
	*/

	do_action( 'pikture_primary_content' );
