<?php
/**
 * Avior functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Avior
 */
if ( ! function_exists( 'avior_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function avior_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on avior, use a find and replace
		 * to change 'avior' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'avior', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 954 );
		add_image_size( 'avior-thumb-large', 1354 );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'avior' ),
			'menu-2' => esc_html__( 'Social', 'avior' ),
			'menu-3' => esc_html__( 'Footer', 'avior' ),
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
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */

		add_theme_support('editor-styles');
		add_editor_style( array( 'css/editor-style.css', avior_fonts_url() ) );

		add_theme_support('editor-color-palette', array(
			array(
				'name' => esc_html__('Color 1', 'avior'),
				'slug' => 'color-1',
				'color' => '#1ca4d3'
			),
			array(
				'name' => esc_html__('Color 2', 'avior'),
				'slug' => 'color-2',
				'color' => '#1f2429'
			),
			array(
				'name' => esc_html__('Color 3', 'avior'),
				'slug' => 'color-3',
				'color' => '#333333'
			),
			array(
				'name' => esc_html__('Color 4', 'avior'),
				'slug' => 'color-4',
				'color' => '#d9d9d9'
			),
			array(
				'name' => esc_html__('Color 5', 'avior'),
				'slug' => 'color-5',
				'color' => '#f5f3f1'
			),
			array(
				'name' => esc_html__('Color 6', 'avior'),
				'slug' => 'color-6',
				'color' => '#202b34'
			),
		));
	}
endif;
add_action( 'after_setup_theme', 'avior_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */
if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'avior_content_width', 954 );
}

/**
 * Get theme vertion.
 *
 * @access public
 * @return string
 */
function avior_get_theme_version() {
	$theme_info = wp_get_theme( get_template() );

	return $theme_info->get( 'Version' );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function avior_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'avior' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'avior' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Left', 'avior' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'avior' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Center', 'avior' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'avior' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Right', 'avior' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'avior' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
        'name'          => esc_html__( 'Shop', 'avior' ),
        'id'            => 'shop',
        'description'   => esc_html__( 'Add widgets here.', 'avior' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}

add_action( 'widgets_init', 'avior_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function avior_scripts() {

	wp_enqueue_style( 'avior-style', get_stylesheet_uri(), array(), avior_get_theme_version() );
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'avior-fonts', avior_fonts_url(), array(), null );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/fonts/font-awesome.css', array(), '4.7.0' );

	wp_enqueue_script( 'avior-navigation', get_template_directory_uri() . '/js/navigation.js', array(), avior_get_theme_version(), true );
	wp_enqueue_script( 'avior-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), avior_get_theme_version(), true );
	wp_enqueue_script( 'avior-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), avior_get_theme_version(), true );
	wp_localize_script( 'avior-script', 'avior_screenReaderText', array(
		'expand'   => esc_html__( 'Expand menu', 'avior' ),
		'collapse' => esc_html__( 'Collapse menu', 'avior' ),
	) );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'avior_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * TGM init.
 */
require get_template_directory() . '/inc/tgmpa-init.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Load WooCommerce compatibility file.
 */
if(class_exists( 'WooCommerce' )){
    require get_template_directory() . '/inc/woocommerce.php';
}
if ( ! function_exists( 'avior_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since Avior 1.0.0
	 */
	function avior_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

if ( ! function_exists( 'avior_fonts_url' ) ) :
	/**
	 * Register Google fonts for Avior.
	 *
	 * Create your own avior_fonts_url() function to override in a child theme.
	 *
	 * @since Avior 1.0.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function avior_fonts_url() {
		$fonts_url     = '';
		$font_families = array();

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by Source Sans Pro, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$source_sans_pro_display = esc_html_x( 'on', 'Source Sans Pro font: on or off', 'avior' );
		if ( 'off' !== $source_sans_pro_display ) {
			$font_families[] = 'Source+Sans+Pro:400,400i,600,600i,700,700i,900,900';
		}

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by Source Serif Pro, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$source_serif_pro_display = esc_html_x( 'on', 'Source Serif Pro font: on or off', 'avior' );
		if ( 'off' !== $source_serif_pro_display ) {
			$font_families[] = 'Source+Serif+Pro:400,600,700';
		}

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by Source Code Pro, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$source_code_pro_display = esc_html_x( 'on', 'Source Code Pro font: on or off', 'avior' );
		if ( 'off' !== $source_code_pro_display ) {
			$font_families[] = 'Source+Code+Pro';
		}

		if ( $font_families ) {
			$query_args = array(
				'family' => implode( '%7C', $font_families ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			if ( $font_families ) {
				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			}
		}

		return esc_url_raw( $fonts_url );
	}
endif;
/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Avior 1.0.0
 *
 * @param array $args Arguments for tag cloud widget.
 *
 * @return array A new modified arguments.
 */
function avior_widget_tag_cloud_args( $args ) {
	$args['largest']  = 0.875;
	$args['smallest'] = 0.875;
	$args['unit']     = 'rem';

	return $args;
}

add_filter( 'widget_tag_cloud_args', 'avior_widget_tag_cloud_args' );

