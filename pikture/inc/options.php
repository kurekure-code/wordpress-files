<?php
/**
 * Pikture options
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */
if ( ! function_exists( 'pikture_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function pikture_sidebar_position() {
        $pikture_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'left-sidebar'  => get_template_directory_uri() . '/assets/images/left.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'pikture_sidebar_position', $pikture_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'pikture_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function pikture_pagination_options() {
        $pikture_pagination_options = array(
            'numeric'  => esc_html__( 'Numeric', 'pikture' ),
            'default' => esc_html__( 'Default(Older/Newer)', 'pikture' ),
        );

        $output = apply_filters( 'pikture_pagination_options', $pikture_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'pikture_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function pikture_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'pikture' ),
            'off'       => esc_html__( 'No', 'pikture' )
        );
        return apply_filters( 'pikture_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'pikture_posts_choices' ) ) :
    /**
     * List of posts choices
     * @return Array Array of posts
     */
    function pikture_posts_choices() {
        $latest = new WP_Query( array(
            'post_type'   => 'post',
            'post_status' => 'publish',
            'orderby'     => 'post_title',
            'order'       => 'ASC',
            'posts_per_page' => -1,
            'cache_results'  => true,
        ));

        $pikture_posts_choices = array();
        if ( $latest->have_posts() ) {
            while( $latest->have_posts() ) {
                $latest->the_post(); 
                
                    $id = get_the_ID();
                    $title = get_the_title();
                    $pikture_posts_choices[ $id ] = $title;
            }
        }

        $output = apply_filters( 'pikture_posts_choices', $pikture_posts_choices );
        return $output;
    }
endif;