<?php
/**
 * Landscape section
 *
 * This is the template for the landscape section
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since 1.0
 */
if ( ! function_exists( 'pikture_add_landscape_section' ) ) :
  /**
   * Add landscape section
   *
   *@since Pikture 1.0.0
   */
  function pikture_add_landscape_section() {
    // Check if landscape is enabled on frontpage
    $enable_landscape_section = apply_filters( 'pikture_section_status', true, 'enable_landscape_section' );
    
    if ( true !== $enable_landscape_section ) {
        return false;
    }

    // Get landscape section details
    $section_details = array();
    $section_details = apply_filters( 'pikture_filter_landscape_section_details', $section_details );

    if ( empty( $section_details ) ) {
      return;
    }

    // Render landscape section now.
    pikture_render_landscape_section( $section_details );
  }
endif;
add_action( 'pikture_content_start_action', 'pikture_add_landscape_section', 20 );


if ( ! function_exists( 'pikture_get_landscape_section_details' ) ) :
  /**
   * landscape section details.
   *
   * @since Pikture 1.0.0
   * @param array $input landscape section details.
   */
  function pikture_get_landscape_section_details( $input ) {
    $options = pikture_get_theme_options();

    // Content type.
    $content = array();
       
    if ( isset( $options['landscape_category'] ) ) {
        $id = $options['landscape_category'];
    }

    if( ! empty ( $id ) ) {
        // Prepare arguments.
        $args = array(
            'ignore_sticky_posts' => true,
            'posts_per_page'      => 6,
            'orderby'             => 'post__in',
            'cat'                 => absint( $id ),
        );

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['down_img'] = get_the_post_thumbnail_url();
                $page_post['img']      = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                $page_post['url']      = get_permalink();

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
// Landscape section content details.
add_filter( 'pikture_filter_landscape_section_details', 'pikture_get_landscape_section_details' );


if ( ! function_exists( 'pikture_render_landscape_section' ) ) :
  /**
   * Start landscape section
   *
   * @return string Landscape content
   * @since Pikture 1.0.0
   *
   */
   function pikture_render_landscape_section( $content_details = array() ) {
        $options        = pikture_get_theme_options();
        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="landscape" class="page-section vertical relative">
            <header class="entry-header align-center">
                <h2 class="entry-title"><?php echo esc_html( $options['landscape_title'] ); ?></h2>
                <div class="seperator"></div>
            </header><!-- .entry-header -->

            <div class="entry-content">
                    <div class="grid gallery-popup">
                        <?php foreach ( $content_details as $content ): 
                            $img_url = ( ! empty( $content['img'] ) ) ? $content['img'] : get_template_directory_uri() . '/assets/uploads/featured-placeholder.jpg';
                            $down_img = ( isset( $content['down_img'] ) ) ? $content['down_img'] : $img_url;
                            ?>
                            <div class="grid-item">
                                <figure>
                                    <?php if ( isset( $content['url'] ) ) { ?>
                                        <a href="<?php echo esc_url( $content['url'] ); ?>">
                                    <?php } ?>
                                        <div class="featured-image" style="background-image: url('<?php echo esc_url( $img_url ); ?>')"></div>
                                    <?php if ( isset( $content['url'] ) ) { ?>
                                        </a>
                                    <?php } ?>

                                    <div class="hover-item">
                                        <?php if ( isset( $content['counter'] ) ) : ?>
                                            <div class="heart-icon">
                                                <?php echo wp_kses_post( $content['counter'] ); ?>
                                            </div>
                                        <?php endif; ?>

                                        <a download href="<?php echo esc_url( $down_img ); ?>" class="download">
                                            <?php echo pikture_get_svg( array( 'icon' => 'download' ) ); ?>
                                        </a><!-- .download -->
                                    </div><!-- .hover-item -->

                                    <?php if ( isset( $content['counter'] ) ) : ?>
                                        <span class="likes">
                                            <?php echo pikture_get_svg( array( 'icon' => 'like' ) ); ?>
                                            <?php echo wp_kses_post( $content['counter'] ); ?>
                                        </span><!-- .likes -->
                                    <?php endif; ?>

                                    <?php if ( isset( $content['url'] ) ) { ?>
                                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="add-to-collection">
                                            <?php echo pikture_get_svg( array( 'icon' => 'collection' ) ); ?>
                                            <span class="collection"><?php esc_html_e( 'Show Detail', 'pikture' ); ?></span>
                                        </a><!-- .add-to-collection -->
                                    <?php } ?>
                                </figure><!-- .featured-image -->
                                
                                <div class="hover-item">
                                    <?php if ( isset( $content['counter'] ) ) : ?>
                                        <div class="heart-icon">
                                            <?php echo wp_kses_post( $content['counter'] ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( isset( $content['counter'] ) ) : ?>
                                        <span class="likes">
                                            <?php echo pikture_get_svg( array( 'icon' => 'like' ) ); ?>
                                            <?php echo wp_kses_post( $content['counter'] ); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ( isset( $content['url'] ) ) { ?>
                                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="add-to-collection">
                                            <?php echo pikture_get_svg( array( 'icon' => 'collection' ) ); ?>
                                            <span class="collection"><?php esc_html_e( 'Show Detail', 'pikture' ); ?></span>
                                        </a>
                                    <?php } ?>

                                    <a download href="<?php echo esc_url( $img_url ); ?>" class="download">
                                        <?php echo pikture_get_svg( array( 'icon' => 'download' ) ); ?>
                                    </a>

                                </div><!-- .hover-item -->
                            </div><!-- .grid-item -->
                        <?php endforeach;?>
                    </div><!-- .grid/gallery-popup -->
            </div><!-- .entry-content -->
            <?php $btn_link = get_category_link( $options['landscape_category'] ); ?>

            <div class="align-center">
                <a href="<?php echo esc_url( $btn_link ); ?>" class="btn btn-green"><?php echo esc_html__( 'View More', 'pikture' ); ?></a>
            </div><!-- .align-center-->
        </div><!-- #landscape -->
<?php
    }
endif;