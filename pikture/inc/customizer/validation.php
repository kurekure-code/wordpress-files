<?php
/**
* Customizer validation functions
*
* @package Theme Palace
* @subpackage Pikture
* @since Pikture 1.0.0
*/

if ( ! function_exists( 'pikture_validate_long_excerpt' ) ) :
  function pikture_validate_long_excerpt( $validity, $value ){
         $value = intval( $value );
     if ( empty( $value ) || ! is_numeric( $value ) ) {
         $validity->add( 'required', esc_html__( 'You must supply a valid number.', 'pikture' ) );
     } elseif ( $value < 5 ) {
         $validity->add( 'min_no_of_words', esc_html__( 'Minimum no of words is 5', 'pikture' ) );
     } elseif ( $value > 100 ) {
         $validity->add( 'max_no_of_words', esc_html__( 'Maximum no of words is 100', 'pikture' ) );
     }
     return $validity;
  }
endif;
