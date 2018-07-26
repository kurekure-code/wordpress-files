<?php
/**
 * About section
 *
 * This is the template for the call to action section
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since 1.0
 */
if ( ! function_exists( 'pikture_add_counter_about_section' ) ) :
  /**
   * Add call to action section
   *
   *@since Pikture 1.0.0
   */
  function pikture_add_counter_about_section() {
    // Check if call to action is enabled on frontpage
    $enable_about_section = apply_filters( 'pikture_section_status', true, 'enable_about_section' );
    
    if ( true !== $enable_about_section ) {
        return false;
    }

    // Get call to action section details
    $section_details = array();
    $section_details = apply_filters( 'pikture_filter_counter_about_section_details', $section_details );

    if ( empty( $section_details ) ) {
      return;
    }

    // Render call to action section now.
    pikture_render_counter_about_section( $section_details );
  }
endif;
add_action( 'pikture_content_start_action', 'pikture_add_counter_about_section', 20 );


if ( ! function_exists( 'pikture_get_counter_about_section_details' ) ) :
  /**
   * call to action section details.
   *
   * @since Pikture 1.0.0
   * @param array $input call to action section details.
   */
  function pikture_get_counter_about_section_details( $input ) {
    $options = pikture_get_theme_options();

    // Content type.
    $content = array();
    if ( isset( $options['about_page_id'] ) ) {
        $id = $options['about_page_id'];
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
                $raw_content = pikture_trim_content( 100 );
                $page_post['content'] = '<p>' . $raw_content . '</p>';
                $page_post['img']       = get_the_post_thumbnail_url();
                $page_post['btn_txt']   = esc_html__( 'View Details', 'pikture' );;
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
// About section content details.
add_filter( 'pikture_filter_counter_about_section_details', 'pikture_get_counter_about_section_details' );


if ( ! function_exists( 'pikture_render_counter_about_section' ) ) :
  /**
   * Start call to action section
   *
   * @return string About content
   * @since Pikture 1.0.0
   *
   */
   function pikture_render_counter_about_section( $content_details = array() ) {
        $about_img      = $content_details[0]['img'];
        $options        = pikture_get_theme_options();

        $col_class = '';
        if ( empty( $about_img ) ) {
            $col_class = 'col-1';
        } else {
            $col_class = 'col-2';
        }
        
        ?>
        <div id="about" class="<?php echo esc_attr( $col_class ); ?> page-section relative">

            <?php
            if ( empty( $content_details ) ) {
                return;
            }

            foreach ( $content_details as $content ): ?>
                <div class="about-text no-counter hentry">
                    <div class="entry-container">
                        <header class="entry-header">
                            <h2 class="entry-title"><?php echo esc_html( $content['title'] ); ?></h2>
                            <div class="seperator"></div>
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <?php echo wp_kses_post( $content['content'] ); ?>
                        </div><!-- .entry-content -->
                        <a href="<?php echo esc_url( $content['btn_url'] ); ?>" class="btn btn-green"><?php echo esc_html( $content['btn_txt'] ); ?></a>
                    </div><!-- .entry-container -->
                </div><!-- .about-text -->

                <?php if ( ! empty( $content['img'] ) ) : ?>
                    <div class="featured hentry">
                       <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['img'] ); ?>');">
                        </div><!-- .featured-image -->
                    </div><!-- .hentry -->
                <?php endif; ?>
            <?php endforeach;?>
        </div><!-- #about -->
<?php
    }
endif;