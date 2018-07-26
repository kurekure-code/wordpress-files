<?php
/**
 * Featured section
 *
 * This is the template for the featured section
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since 1.0
 */
if ( ! function_exists( 'pikture_add_featured_section' ) ) :
  /**
   * Add featured section
   *
   *@since Pikture 1.0.0
   */
  function pikture_add_featured_section() {
    // Check if featured is enabled on frontpage
    $featured_enable = apply_filters( 'pikture_section_status', true, 'enable_featured_section' );

    if ( true !== $featured_enable ) {
        return false;
    }
    // Get featured section details
    $section_details = array();
    $section_details = apply_filters( 'pikture_filter_featured_section_details', $section_details );

    if ( empty( $section_details ) ) {
      return;
    }

    // Render featured section now.
    pikture_render_featured_section( $section_details );
  }
endif;
add_action( 'pikture_content_start_action', 'pikture_add_featured_section', 20 );


if ( ! function_exists( 'pikture_get_featured_section_details' ) ) :
  /**
   * featured section details.
   *
   * @since Pikture 1.0.0
   * @param array $input featured section details.
   */
  function pikture_get_featured_section_details( $input ) {
    $options = pikture_get_theme_options();

    $content = array();

    $id_arr = array();
    for ( $i=1; $i < 4; $i++ ) {
        if ( isset( $options['featured_post_id_' . $i ] ) ) {
            array_push( $id_arr, $options['featured_post_id_' . $i ] );
        }
    }

    // Remove any empty values.
    $id_arr = array_filter( $id_arr );
    if( ! empty ( $id_arr ) ) {
        // Prepare arguments.
        $args = array(
            'post__in'            => $id_arr,
            'ignore_sticky_posts' => true,
            'orderby'             => 'post__in',
            'posts_per_page'      => 3
        );

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']    = get_the_title();
                $page_post['url']      = get_permalink();
                $page_post['down_img'] = get_the_post_thumbnail_url();
                $page_post['img']      = get_the_post_thumbnail_url( get_the_ID(), 'large' );

                // Add counter data from Heart This plugin.
                if ( function_exists( 'heart_this_get_hearts' ) ) {
                    $page_post['counter'] = heart_this_get_hearts( get_the_ID() );
                }

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
// Featured section content details.
add_filter( 'pikture_filter_featured_section_details', 'pikture_get_featured_section_details' );


if ( ! function_exists( 'pikture_render_featured_section' ) ) :
  /**
   * Start featured section
   *
   * @return string Featured content
   * @since Pikture 1.0.0
   *
   */
   function pikture_render_featured_section( $content_details = array() ) {
        $options          = pikture_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="featured-section" class="col-3 relative">
            <?php foreach ( $content_details as $content ): 

                $img_url = ( ! empty( $content['img'] ) ) ? $content['img'] : get_template_directory_uri() . '/assets/uploads/featured-placeholder.jpg';
                
                $down_img = ( isset( $content['down_img'] ) ) ? $content['down_img'] : $img_url;
                ?>
                <article class="hentry">
                    <div class="featured-image" style="background-image: url('<?php echo esc_url( $img_url ); ?>');">
                        <div class="overlay"></div>
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                        </header><!-- .entry-header -->
                    </div><!-- .featured-image -->

                    <div class="hover-item">
                        <?php if ( isset( $content['counter'] ) ) : ?>
                            <div class="heart-icon">
                                <?php echo wp_kses_post( $content['counter'] ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( isset( $content['counter'] ) ) : ?>
                            <span data-count="" class="likes">
                               <?php echo pikture_get_svg( array( 'icon' => 'like' ) ); ?>
                                <?php echo wp_kses_post( $content['counter'] ); ?>
                            </span>
                        <?php endif; ?>

                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="add-to-collection">
                            <?php echo pikture_get_svg( array( 'icon' => 'collection' ) ); ?>
                            <span class="collection"><?php esc_html_e( 'Show Detail', 'pikture' ); ?></span>
                        </a>

                        <a download href="<?php echo esc_url( $down_img ); ?>" class="download">
                            <?php echo pikture_get_svg( array( 'icon' => 'download' ) ); ?>
                        </a>
                    </div><!-- .hover-item -->
                </article><!-- .article -->
            <?php endforeach; ?>
        </div><!-- .featured-section -->
<?php
    }
endif;