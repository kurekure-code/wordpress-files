<?php
/**
 * Pikture functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Theme Palace
 * @subpackage Pikture
 * @since Pikture 1.0.0
 */

if ( ! function_exists( 'pikture_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pikture_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Theme Palace, use a find and replace
		 * to change 'pikture' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pikture' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets', 4 );

		// Load Footer Widget Support.
		require_if_theme_supports( 'footer-widgets', get_template_directory() . '/inc/footer-widgets.php' );
		
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Set the default content width.
		$GLOBALS['content_width'] = 525;
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'pikture' ),
			'social' => esc_html__( 'Social', 'pikture' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'pikture_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// This setup supports logo, site-title & site-description
		add_theme_support( 'custom-logo', array(
			'height'      => 45,
			'width'       => 120,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css', pikture_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'pikture_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pikture_content_width() {

	$content_width = $GLOBALS['content_width'];


	$sidebar_position = pikture_layout();
	switch ( $sidebar_position ) {

	  case 'no-sidebar':
	    $content_width = 1170;
	    break;

	  case 'left-sidebar':
	  case 'right-sidebar':
	    $content_width = 819;
	    break;

	  default:
	    break;
	}

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 1170;
	}

	/**
	 * Filter Pikture content width of the theme.
	 *
	 * @since Pikture 1.0.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'pikture_content_width', $content_width );
}
add_action( 'template_redirect', 'pikture_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pikture_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'pikture' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'pikture' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pikture_widgets_init' );


if ( ! function_exists( 'pikture_fonts_url' ) ) :
/**
 * Register Google fonts
 *
 * @return string Google fonts URL for the theme.
 */
function pikture_fonts_url() {
    $options= pikture_get_theme_options();

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Ubuntu font: on or off', 'pikture' ) ) {
		$fonts[] = 'Ubuntu:300,400,500,700';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'pikture' ) ) {
		$fonts[] = 'Playfair Display:400,400i,700,700i,900';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $fonts ) ),
		'subset' => urlencode( $subsets ),
	);

	if ( $fonts ) {
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}
endif;

/**
 * Add preconnect for Google Fonts.
 *
 * @since Pikture 1.0.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function pikture_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'pikture-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'pikture_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function pikture_scripts() {
	$options = pikture_get_theme_options();
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'pikture-fonts', pikture_fonts_url(), array(), null );

	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/assets/css/slick-theme' . pikture_min() . '.css', array(), '20151215' );

	wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/css/slick' . pikture_min() . '.css', array(), '20151215' );

	wp_enqueue_style( 'pikture-style', get_stylesheet_uri() );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/assets/js/html5' . pikture_min() . '.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'pikture-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix' . pikture_min() . '.js', array(), '20160412', true );

	wp_enqueue_script( 'pikture-navigation', get_template_directory_uri() . '/assets/js/navigation' . pikture_min() . '.js', array(), '20151215', true );
	
	$pikture_l10n = array(
		'quote'          => pikture_get_svg( array( 'icon' => 'quote-right' ) ),
		'expand'         => esc_html__( 'Expand child menu', 'pikture' ),
		'collapse'       => esc_html__( 'Collapse child menu', 'pikture' ),
		'icon'           => pikture_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
	);
	
	wp_localize_script( 'pikture-navigation', 'pikture_l10n', $pikture_l10n );

	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick' . pikture_min() . '.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'packery-js', get_template_directory_uri() . '/assets/js/packery-mode' . pikture_min() . '.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'match-height-js', get_template_directory_uri() . '/assets/js/jquery.matchHeight.min.js', array( 'jquery' ), '20151215', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'pikture-custom', get_template_directory_uri() . '/assets/js/custom' . pikture_min() . '.js', array(), '20151215', true );
}
add_action( 'wp_enqueue_scripts', 'pikture_scripts' ); 

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load core file
 */
require get_template_directory() . '/inc/core.php';