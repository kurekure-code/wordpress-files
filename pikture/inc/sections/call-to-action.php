<?php
/**
 * Call to action section
 *
 * This is the template for the call to action section
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since 1.0
 */
if ( ! function_exists( 'pikture_add_call_to_action_section' ) ) :
  /**
   * Add call to action section
   *
   *@since Pikture 1.0.0
   */
  function pikture_add_call_to_action_section() {
    // Check if call to action is enabled on frontpage
    $enable_call_to_action_section = apply_filters( 'pikture_section_status', true, 'enable_call_to_action_section' );
    
    if ( true !== $enable_call_to_action_section ) {
        return false;
    }

    // Get call to action section details
    $section_details = array();
    $section_details = apply_filters( 'pikture_filter_call_to_action_section_details', $section_details );

    if ( empty( $section_details ) ) {
      return;
    }

    // Render call to action section now.
    pikture_render_call_to_action_section( $section_details );
  }
endif;
add_action( 'pikture_content_start_action', 'pikture_add_call_to_action_section', 20 );


if ( ! function_exists( 'pikture_get_call_to_action_section_details' ) ) :
  /**
   * call to action section details.
   *
   * @since Pikture 1.0.0
   * @param array $input call to action section details.
   */
  function pikture_get_call_to_action_section_details( $input ) {
    $options = pikture_get_theme_options();

    // Content type.
    $content = array();
    if ( isset( $options['call_to_action_page_id'] ) ) {
        $id = $options['call_to_action_page_id'];
    }
    if( ! empty ( $id ) ) {
        // Prepare arguments.
        $args = array(
            'post_type'           => 'page',
            'p'                   => $id,
            'ignore_sticky_posts' => true
        );

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                // Check if it is post or page. If post get excerpt. If page, strip the content.
                $post_type = get_post_type();
                $raw_content = pikture_trim_content( 100 ) ;
                $page_post['content'] = '<p>' . $raw_content . '</p>';
                
                $page_post['img']       = get_the_post_thumbnail_url();
                $page_post['btn_txt']   = esc_html__( 'View More', 'pikture' );
                $page_post['btn_url']   = get_permalink();

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
            wp_reset_postdata();
        endif;
    }

    if ( ! empty( $content ) ) {
      $input = $content;
    }
    return $input;
  }
endif;
// Call to action section content details.
add_filter( 'pikture_filter_call_to_action_section_details', 'pikture_get_call_to_action_section_details' );


if ( ! function_exists( 'pikture_render_call_to_action_section' ) ) :
  /**
   * Start call to action section
   *
   * @return string Call to action content
   * @since Pikture 1.0.0
   *
   */
   function pikture_render_call_to_action_section( $content_details = array() ) {
        foreach ( $content_details as $content ): ?>
            <div id="call-to-action" class="relative" style="background-image: url('<?php echo esc_html( $content['img'] ); ?>');">
                <div class="overlay"></div>
                <div class="container">
                    <header class="entry-header">
                        <h2 class="entry-title"><?php echo esc_html( $content['title'] ); ?></h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p><?php echo wp_kses_post( $content['content'] ); ?></p>
                    </div><!-- .entry-content -->

                    <?php if ( ! empty( $content['btn_txt'] ) ) : ?>
                        <div class="align-center">
                            <a href="<?php echo esc_url( $content['btn_url'] ); ?>" class="btn btn-white"><?php echo esc_html( $content['btn_txt'] ); ?></a>
                        </div>
                    <?php endif; ?>
                </div><!-- .container -->
            </div><!-- #call-to-action -->
        <?php endforeach;
    }
endif;