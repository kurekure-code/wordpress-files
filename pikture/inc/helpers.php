<?php
/**
 * Pikture custom helper funtions
 *
 * This is the template that includes all the other files for core featured of Pikture
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

if( ! function_exists( 'pikture_check_enable_status' ) ):
	/**
	 * Check status of content.
	 *
	 * @since Pikture 1.0.0
	 */
  	function pikture_check_enable_status( $input, $content_enable ){
		$options = pikture_get_theme_options();

		// Content status.
		$content_status = $options[ $content_enable ];

		if ( ( ! is_home() && is_front_page() ) && $content_status ) {
			$input = true;
		}
		else {
			$input = false;
		}
		
		return $input;
  	}
endif;
add_filter( 'pikture_section_status', 'pikture_check_enable_status', 10, 2 );


if ( ! function_exists( 'pikture_is_sidebar_enable' ) ) :
	/**
	 * Check if sidebar is enabled in meta box first then in customizer
	 *
	 * @since Pikture 1.0.0
	 */
	function pikture_is_sidebar_enable() {
		$options               = pikture_get_theme_options();
		$sidebar_position      = $options['sidebar_position'];

		if ( is_single() ) {
			$sidebar_position = $options['post_sidebar_position'];
		} elseif ( is_page() ) {
			$sidebar_position = $options['page_sidebar_position'];
		}
		
		if ( is_archive() || is_search() ) {
			$sidebar_position = $options['sidebar_position'];
		}

		if ( $sidebar_position == 'no-sidebar' ) {
			return false;
		} else {
			return true;
		}
	}
endif;


if ( ! function_exists( 'pikture_is_frontpage_content_enable' ) ) :
	/**
	 * Check home page ( static ) content status.
	 *
	 * @param bool $status Home page content status.
	 * @return bool Modified home page content status.
	 */
	function pikture_is_frontpage_content_enable( $status ) {
		if ( is_front_page() ) {
			$options = pikture_get_theme_options();
			$front_page_content_status = $options['enable_frontpage_content'];
			if ( false === $front_page_content_status ) {
				$status = false;
			}
		}
		return $status;
	}

endif;

add_filter( 'pikture_filter_frontpage_content_enable', 'pikture_is_frontpage_content_enable' );


add_action( 'pikture_action_pagination', 'pikture_pagination', 10 );
if ( ! function_exists( 'pikture_pagination' ) ) :

	/**
	 * pagination.
	 *
	 * @since Pikture 1.0.0
	 */
	function pikture_pagination() {
		$options = pikture_get_theme_options();
		if ( true == $options['pagination_enable'] ) {
			$pagination = $options['pagination_type'];
			if ( $pagination == 'default' ) :
				the_posts_navigation( array( 
					'prev_text'          => pikture_get_svg( array( 'icon' => 'bold-arrow' ) ) . esc_html__( 'Older posts', 'pikture' ),
					'next_text'          => esc_html__( 'Newer posts', 'pikture' ) . pikture_get_svg( array( 'icon' => 'bold-arrow' ) ),
				) );
			elseif ( $pagination == 'numeric' ) :
				the_posts_pagination( array(
				    'mid_size' => 4,
				    'prev_text' => pikture_get_svg( array( 'icon' => 'bold-arrow' ) ) . esc_html__( 'Previous Posts', 'pikture' ),
				    'next_text' => esc_html__( 'Next Posts', 'pikture' ) . pikture_get_svg( array( 'icon' => 'bold-arrow' ) ),
				    'before_page_number' => '<span>',
				    'after_page_number' => '</span>'
				) );
			endif;
		}
	}

endif;


add_action( 'pikture_action_post_pagination', 'pikture_post_pagination', 10 );
if ( ! function_exists( 'pikture_post_pagination' ) ) :

	/**
	 * post pagination.
	 *
	 * @since Pikture 1.0.0
	 */
	function pikture_post_pagination() {
		$options = pikture_get_theme_options();
		if ( $options['pagination_enable'] ) {
		the_post_navigation( array(
				'prev_text'          => pikture_get_svg( array( 'icon' => 'bold-arrow' ) ) . '%title',
				'next_text'          => '%title' . pikture_get_svg( array( 'icon' => 'bold-arrow' ) ),
			) );
		}
	}
endif;


if ( ! function_exists( 'pikture_excerpt_length' ) ) :
	/**
	 * long excerpt
	 * 
	 * @since Pikture 1.0.0
	 * @return long excerpt value
	 */
	function pikture_excerpt_length( $length ){
		if ( is_admin() ) {
			return $length;
		}

		$options = pikture_get_theme_options();
		$length = $options['long_excerpt_length'];
		return $length;
	}
endif;
add_filter( 'excerpt_length', 'pikture_excerpt_length', 999 );


if ( ! function_exists( 'pikture_excerpt_more' ) ) :
	// Read more
	function pikture_excerpt_more( $more ){
		if ( is_admin() ) {
			return $more;
		}
		
		$options = pikture_get_theme_options();
		return sprintf( '<a class="read-more" href="%1$s"> %2$s</a>', esc_url(get_permalink() ), esc_html( $options['read_more_text'] ) );
	}
endif;
add_filter( 'excerpt_more', 'pikture_excerpt_more' );


if ( ! function_exists( 'pikture_trim_content' ) ) :
	/**
	 * custom excerpt function
	 * 
	 * @since Pikture 1.0.0
	 * @return  no of words to display
	 */
	function pikture_trim_content( $length = 40, $post_obj = null ) {
		global $post;
		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}

		$length = absint( $length );
		if ( $length < 1 ) {
			$length = 40;
		}

		$source_content = $post_obj->post_content;
		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}

		$source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );

	   return apply_filters( 'pikture_trim_content', $trimmed_content );
	}
endif;


if ( ! function_exists( 'pikture_layout' ) ) :
	/**
	 * Check home page layout option
	 *
	 * @since Pikture 1.0.0
	 *
	 * @return string Pikture layout value
	 */
	function pikture_layout() {
		$options               = pikture_get_theme_options();
		$sidebar_position      = $options['sidebar_position'];

		if ( is_single() ) {
			$sidebar_position = $options['post_sidebar_position'];
		} elseif ( is_page() ) {
			$sidebar_position = $options['page_sidebar_position'];
		}
		
		if ( is_archive() || is_search() ) {
			$sidebar_position      = $options['sidebar_position'];
		}

		return $sidebar_position;
	}
endif;

/**
 * Add SVG definitions to the footer.
 */
function pikture_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/images/svg-icons.svg';

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
add_action( 'wp_footer', 'pikture_include_svg_icons', 9999 );

/**
 * Return SVG markup.
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function pikture_get_svg( $args = array() ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'pikture' );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'pikture' );
	}

	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'fallback'    => false,
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Set aria hidden.
	$aria_hidden = ' aria-hidden="true"';

	// Set ARIA.
	$aria_labelledby = '';

	/*
	 * Pikture doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
	 *
	 * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
	 *
	 * Example 1 with title: <?php echo pikture_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
	 *
	 * Example 2 with title and description: <?php echo pikture_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
	 *
	 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
	 */
	if ( $args['title'] ) {
		$aria_hidden     = '';
		$unique_id       = uniqid();
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( $args['desc'] ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	// Begin SVG markup.
	$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

	// Display the title.
	if ( $args['title'] ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		// Display the desc only if the title is already set.
		if ( $args['desc'] ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	/*
	 * Display the icon.
	 *
	 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
	 *
	 * See https://core.trac.wordpress.org/ticket/38387.
	 */
	$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';

	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function pikture_social_links_icons() {
	// Supported social links icons.
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'envelope-o',
		'medium.com'      => 'medium',
		'pinterest.com'   => 'pinterest-p',
		'getpocket.com'   => 'get-pocket',
		'reddit.com'      => 'reddit-alien',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat-ghost',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filter Pikture social links icons.
	 *
	 * @since Pikture 1.0.0
	 *
	 * @param array $social_links_icons Array of social links icons.
	 */
	return apply_filters( 'pikture_social_links_icons', $social_links_icons );
}

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function pikture_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Get supported social icons.
	$social_icons = pikture_social_links_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . pikture_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'pikture_nav_menu_social_icons', 10, 4 );

/**
 * Fallback function call for menu
 * @param  Mixed $args Menu arguments
 * @return String $output Return or echo the add menu link.       
 */
function pikture_menu_fallback_cb( $args ){
    if ( ! current_user_can( 'edit_theme_options' ) ){
	    return;
   	}
    // see wp-includes/nav-menu-template.php for available arguments
    $link = $args['link_before']
        	. '<a href="' .esc_url( admin_url( 'nav-menus.php' ) ) . '">' . $args['before'] . esc_html__( 'Add a menu','pikture' ) . $args['after'] . '</a>'
        	. $args['link_after'];

   	if ( FALSE !== stripos( $args['items_wrap'], '<ul' ) || FALSE !== stripos( $args['items_wrap'], '<ol' )
	){
		$link = "<li>$link</li>";
	}
	$output = sprintf( $args['items_wrap'], $args['menu_id'], $args['menu_class'], $link );
	if ( ! empty ( $args['container'] ) ){
		$output = sprintf( '<%1$s class="%2$s" id="%3$s">%4$s</%1$s>', $args['container'], $args['container_class'], $args['container_id'], $output );
	}
	if ( $args['echo'] ){
		echo $output;
	}
	return $output;
}

/**
 * Function to detect SCRIPT_DEBUG on and off.
 * @return string If on, empty else return .min string.
 */
function pikture_min() {
	return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
}

/**
 * Display SVG icons as per the link.
 *
 * @param  string   $social_link        Theme mod value rendered
 * @return string  SVG icon HTML
 */
function pikture_return_social_icon( $social_link ) {
	// Get supported social icons.
	$social_icons = pikture_social_links_icons();

	// Check in the URL for the url in the array.
	foreach ( $social_icons as $attr => $value ) {
		if ( false !== strpos( $social_link, $attr ) ) {
			return pikture_get_svg( array( 'icon' => esc_attr( $value ) ) );
		}
	}
}

/**
 * Checks to see if we're on the homepage or not.
 */
function pikture_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function pikture_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Change the HTML structure of Heart This plugin's default structure.
 * @param  string $output   HTML structure to display the heart.
 * @param  int $post_id 	Post id of the post in the loop
 * @return string           Customized HTML structure.
 */
if ( function_exists( 'heart_this_get_hearts' ) ) {

	function pikture_filter_heart_this_html( $output, $post_id ) {
	    $post_id = get_the_ID();
	    $output = sprintf( '<a href="#" class="heart-this" id="heart-this-%s" data-post-id="%s">%s<span>%s</span></a>',
			uniqid(),
			absint( $post_id ),
			pikture_get_svg( array( 'icon' => 'heart' ) ),
			number_format_i18n( heart_this_get_meta( $post_id ) )
		);
		
	    return $output;
	}
	add_filter( 'heart_this_hearts', 'pikture_filter_heart_this_html', 10, 2 );

	// Remove the like icon from the content.
	remove_filter( 'the_content', 'heart_this_the_content' );
}

function pikture_comment( $comment, $args, $depth ) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','pikture' ); ?></em>
          <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
        <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>', 'pikture' ), get_comment_author_link() ); 
        
        /* translators: 1: date, 2: time */
        printf( __('%1$s at %2$s', 'pikture' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'pikture' ), '  ', '' );
        
        comment_text(); ?>
    </div>


    <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif;
}