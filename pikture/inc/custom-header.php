<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

if ( ! function_exists( 'pikture_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see pikture_custom_header_setup().
	 */
	function pikture_header_style() {
		$options = pikture_get_theme_options();
		$css = '';

		$header_title_color = $options['header_title_color'];
		$header_tagline_color = $options['header_tagline_color'];


		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
		 */
		if ( $header_title_color && $header_tagline_color ) {
			$css .='
			.site-title a,
			#site-header .site-title a {
				color: '.esc_attr( $header_title_color ).';
			}
			.site-description {
				color: '.esc_attr( $header_tagline_color ).';
			}';
		} else {
			$css .='
			.site-title,
			.site-description {
				clip: rect(1px, 1px, 1px, 1px);
			}';
		}
		wp_add_inline_style( 'pikture-style', $css );
	}
endif;
add_action( 'wp_enqueue_scripts', 'pikture_header_style', 10 );