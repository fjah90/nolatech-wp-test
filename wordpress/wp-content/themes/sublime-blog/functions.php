<?php
/**
 * Sublime Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sublime_Blog
 */
$theme_data = wp_get_theme();
if( ! defined( 'SUBLIME_BLOG_VERSION' ) ) define ( 'SUBLIME_BLOG_VERSION', $theme_data->get( 'Version' ) );
if( ! defined( 'SUBLIME_BLOG_NAME' ) ) define( 'SUBLIME_BLOG_NAME', $theme_data->get( 'Name' ) );
if( ! defined( 'SUBLIME_BLOG_TEXTDOMAIN' ) ) define( 'SUBLIME_BLOG_TEXTDOMAIN', $theme_data->get( 'TextDomain' ) );

if ( ! function_exists( 'sublime_blog_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function sublime_blog_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Sublime Blog, use a find and replace
		 * to change 'sublime-blog' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'sublime-blog', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'sublime-blog' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'sublime_blog_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
			'header-text' => array( 'site-title', 'site-description' )
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		add_image_size( 'sublime-blog-slider', 1140, 524, true );
		add_image_size( 'sublime-blog-featured', 720, 465, true );

		/* WooCommerce Support */
		add_theme_support( 'woocommerce' );
	}
endif;
add_action( 'after_setup_theme', 'sublime_blog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sublime_blog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sublime_blog_content_width', 780 );
}
add_action( 'after_setup_theme', 'sublime_blog_content_width', 0 );

if( ! function_exists( 'sublime_blog_template_redirect_content_width' ) ) :
	/**
	* Adjust content_width value according to template.
	*/
	function sublime_blog_template_redirect_content_width(){	
		$sidebar_layout = sublime_blog_sidebar_layout();	
		if( is_singular() ){
			if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'sidebar' ) ) ) $GLOBALS['content_width'] = 1180;
		 }elseif ( ! ( is_active_sidebar( 'sidebar' ) ) ) {
			 $GLOBALS['content_width'] = 1180;
		 }           
	}
endif;
add_action( 'template_redirect', 'sublime_blog_template_redirect_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sublime_blog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'sublime-blog' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'sublime-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer One', 'sublime-blog' ),
		'id'            => 'footer-one',
		'description'   => esc_html__( 'Add widgets here.', 'sublime-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Two', 'sublime-blog' ),
		'id'            => 'footer-two',
		'description'   => esc_html__( 'Add widgets here.', 'sublime-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Three', 'sublime-blog' ),
		'id'            => 'footer-three',
		'description'   => esc_html__( 'Add widgets here.', 'sublime-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'sublime_blog_widgets_init' );

if ( ! function_exists( 'sublime_blog_fonts_url' ) ) :
	/**
	 * Create your own sublime_blog_fonts_url() function to override in a child theme.
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function sublime_blog_fonts_url() {
		$fonts_url = '';
		$fonts     = array();

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Poppins, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'sublime-blog' ) ) {
			$fonts[] = 'Poppins:400,400i,500,500i,600,600i,700,700i';
		}

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Leckerli One, translate this to 'off'. Do not translate into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Leckerli One font: on or off', 'sublime-blog' ) ) {
			$fonts[] = 'Leckerli One';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family'  => urlencode( implode( '|', $fonts ) ),
					'display' => urlencode( 'swap' ),
				),
				'https://fonts.googleapis.com/css'
			);
		}

		return esc_url( $fonts_url );
	}
endif;

if( ! function_exists( 'sublime_blog_flush_local_google_fonts' ) ){
	/**
	 * Ajax Callback for flushing the local font
	 */
  	function sublime_blog_flush_local_google_fonts() {
		$WebFontLoader = new Sublime_Blog_WebFont_Loader();
		//deleting the fonts folder using ajax
		$WebFontLoader->delete_fonts_folder();
		die();
  	}
}
add_action( 'wp_ajax_flush_local_google_fonts', 'sublime_blog_flush_local_google_fonts' );
add_action( 'wp_ajax_nopriv_flush_local_google_fonts', 'sublime_blog_flush_local_google_fonts' );


/**
 * Enqueue scripts and styles.
 */
function sublime_blog_scripts() {

	$slider_auto       = get_theme_mod( 'slider_auto', true );
	$slider_loop       = get_theme_mod( 'slider_loop', true );
	$slider_transition = get_theme_mod( 'slider_animation' );
	$slider_speed      = get_theme_mod( 'slider_speed', '1000' );
	$slider_pause      = get_theme_mod( 'slider_timeout', '5000' );

	$theme_version = wp_get_theme()->get( 'Version' );
	// Use minified libraries if SCRIPT_DEBUG is false
	$build = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	
	// Add custom fonts, used in the main stylesheet.
	if( get_theme_mod( 'ed_localgoogle_fonts',false ) && ! is_customize_preview() && ! is_admin() ){
        wp_enqueue_style( 'sublime-blog-google-fonts', sublime_blog_get_webfont_url( sublime_blog_fonts_url() ) );
    }else{
		wp_enqueue_style( 'sublime-blog-fonts', sublime_blog_fonts_url(), array(), null );
	}
	wp_enqueue_style( 'animate', get_template_directory_uri(). '/css/animate' . $build . '.css', array(), '3.5.2' );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel'. $build .'.css', array(), '2.3.4' );
	wp_enqueue_style( 'sublime-blog-style', get_template_directory_uri() . '/css/main'. $build .'.css', array(), $theme_version );

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel'. $build .'.js', array('jquery'), '2.3.4', true );
	wp_enqueue_script( 'owlcarousel2-a11ylayer', get_template_directory_uri() . '/js/owlcarousel2-a11ylayer'. $build .'.js', array('jquery', 'owl-carousel'), '2.0.0', true );	
	wp_enqueue_script( 'all', get_template_directory_uri() . '/js/all'. $build .'.js', array('jquery'), '5.3.1', true );
	wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js/v4-shims'. $build .'.js', array('jquery'), '5.3.1', true );
	wp_enqueue_script( 'sublime-blog-modal-accessibility', get_template_directory_uri() . '/js/modal-accessibility'. $build .'.js', array('jquery'), $theme_version, true );
	wp_enqueue_script( 'sublime-blog-custom', get_template_directory_uri() . '/js/custom'. $build .'.js', array('jquery'), $theme_version, true );
	
    $localize_array = array(
		'auto'   => (bool) $slider_auto,
		'loop'   => (bool) $slider_loop,
		'mode'   => esc_attr( $slider_transition ),
		'speed'  => absint( $slider_speed ),
		'pause'  => absint( $slider_pause ),
		'rtl'    => is_rtl(),
	);
	
    wp_localize_script( 'sublime-blog-custom', 'sublime_blog_data', $localize_array );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sublime_blog_scripts' );

if ( ! function_exists( 'sublime_blog_svg_collection' ) ) :    
	/**
	 * Get SVG Image
	*/
	function sublime_blog_svg_collection( $svg_name ){
	
		if( !$svg_name ){
			return;
		}
		switch ( $svg_name ) {
	
			case 'sublime': 
				return '<svg width="186" height="79" viewBox="0 0 186 79" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M115.394 19.9443C112.123 1.3906 106.825 -2.17493 88.4353 1.0651H88.4368C70.0481 4.30963 66.289 9.46818 69.5606 28.0264C72.8336 46.5845 77.6997 50.2206 96.5188 46.904C115.337 43.5845 118.665 38.4965 115.394 19.9443ZM88.3797 30.1352L85.9642 34.319C85.7943 34.691 85.7107 35.1049 85.7327 35.5266C85.7414 35.694 85.7663 35.8622 85.8095 36.0304C86.0295 36.8879 86.6626 37.5202 87.439 37.7725C87.8862 37.9184 88.3823 37.938 88.8749 37.8002L99.1082 34.946C102.607 33.9695 104.71 30.3264 103.807 26.808C102.903 23.2898 99.3344 21.2294 95.8359 22.2061L89.5008 23.9741C87.6162 24.4993 85.6949 23.3901 85.2083 21.4958C84.7223 19.6014 85.855 17.6395 87.7382 17.114L96.7904 14.5874L95.3446 17.0916L88.2414 19.0742C87.4338 19.2996 86.9487 20.1398 87.1573 20.9519C87.366 21.764 88.1889 22.2391 88.9969 22.014L96.3056 19.9743C96.936 19.7983 97.4478 19.3979 97.7792 18.8827L100.073 14.9097C100.279 14.5098 100.382 14.0559 100.358 13.592C100.349 13.4246 100.325 13.2564 100.281 13.0882C100.062 12.2336 99.4334 11.603 98.6602 11.3488C98.2101 11.2007 97.711 11.1799 97.2159 11.3184L86.9828 14.1732C83.4841 15.1493 81.3807 18.7924 82.2845 22.3108C83.1883 25.8292 86.7568 27.8894 90.2557 26.913L96.5908 25.145C98.475 24.6195 100.397 25.729 100.883 27.623C101.369 29.5176 100.237 31.4795 98.353 32.0049L89.3129 34.5278L90.7584 32.0239L97.8489 30.0451C98.6565 29.8198 99.1419 28.9792 98.9332 28.1671C98.7246 27.355 97.9017 26.8799 97.0937 27.105L89.7847 29.1451C89.1966 29.3093 88.7116 29.6687 88.3797 30.1352Z" fill="#212327"/><path d="M7.82993 78.9992C11.4048 78.9992 15.3101 77.2591 15.25 73.2185C15.25 66.3466 4.01476 68.6176 4.0448 64.5475C4.01476 63.1613 5.33655 61.9521 7.70976 61.9521C9.78257 61.9521 10.9241 62.365 12.4562 63.1613C12.6965 63.2793 12.9669 63.3678 13.2072 63.3678C13.9883 63.3678 14.7393 62.7189 14.7393 61.8931C14.7693 61.2737 14.3788 60.8314 13.9883 60.5954C12.6064 59.6811 9.96282 58.7373 7.70976 58.7373C3.8946 58.7373 0.5 60.7134 0.5 64.695C0.5 71.9208 11.7352 69.6498 11.7352 73.4544C11.7352 74.8996 10.083 75.9024 7.67973 75.8434C5.8172 75.8139 4.46537 75.1945 3.20366 74.5752C2.9333 74.4277 2.60285 74.3687 2.45264 74.3687C1.61151 74.3687 0.800407 75.0471 0.770366 76.0204C0.740325 76.6102 1.10081 77.0821 1.58146 77.4065C2.90325 78.2618 5.36659 79.0287 7.82993 78.9992Z" fill="black"/><path d="M28.4151 64.5475C27.4538 64.5475 26.7028 65.3143 26.7028 66.2286V72.5402C26.7028 74.5162 25.2308 75.9319 23.3682 75.9319C21.6259 75.9319 20.1238 74.7227 20.1238 72.6876V66.2286C20.1238 65.2848 19.3728 64.5475 18.4416 64.5475C17.5103 64.5475 16.7292 65.3143 16.7292 66.2286V73.189C16.7292 76.8757 19.0123 78.9992 22.2567 78.9992C24.1793 78.9992 25.7114 78.2913 26.7028 77.0526V77.1706C26.7028 78.0849 27.4538 78.8222 28.4151 78.8222C29.3463 78.8222 30.0974 78.0849 30.0974 77.1706V66.2286C30.0974 65.3143 29.3463 64.5475 28.4151 64.5475Z" fill="black"/><path d="M40.2382 64.3705C38.4658 64.3705 36.8736 65.0784 35.702 66.2876V59.7106C35.702 58.7668 34.921 58 33.9897 58C33.0284 58 32.2474 58.7668 32.2474 59.7106V77.1411C32.2474 78.0849 33.0284 78.8222 33.9897 78.8222C34.921 78.8222 35.702 78.0849 35.702 77.1411V77.1116C36.8736 78.3208 38.4658 78.9992 40.2382 78.9992C43.8731 78.9992 46.8471 75.9614 46.8471 71.6849C46.8471 67.4083 43.8731 64.3705 40.2382 64.3705ZM39.4571 75.9319C37.3242 75.9319 35.5819 74.1623 35.5819 71.6849C35.5819 69.2074 37.3242 67.4378 39.4571 67.4378C41.59 67.4378 43.3324 69.2074 43.3324 71.6849C43.3324 74.1623 41.59 75.9319 39.4571 75.9319Z" fill="black"/><path d="M50.4717 78.8222C51.403 78.8222 52.1841 78.0849 52.1841 77.1411V59.7106C52.1841 58.7668 51.403 58 50.4717 58C49.5104 58 48.7294 58.7668 48.7294 59.7106V77.1411C48.7294 78.0849 49.5104 78.8222 50.4717 78.8222Z" fill="black"/><path d="M56.3339 62.9549C57.4154 62.9549 58.3166 62.1291 58.3166 60.9493C58.3166 59.7991 57.4154 58.9733 56.3339 58.9733C55.2224 58.9733 54.3212 59.7991 54.3212 60.9493C54.3212 62.1291 55.2224 62.9549 56.3339 62.9549ZM56.3339 78.8222C57.2652 78.8222 58.0462 78.0849 58.0462 77.1411V66.2286C58.0462 65.3143 57.2652 64.5475 56.3339 64.5475C55.3726 64.5475 54.6216 65.3143 54.6216 66.2286V77.1411C54.6216 78.0849 55.3726 78.8222 56.3339 78.8222Z" fill="black"/><path d="M78.1441 64.3705C75.831 64.3705 74.0286 65.3438 72.9771 66.8775C72.0459 65.2553 70.3636 64.3705 68.2608 64.3705C66.3382 64.3705 64.8361 65.1079 63.8147 66.3466V66.1991C63.8147 65.2848 63.0637 64.5475 62.1325 64.5475C61.2012 64.5475 60.4201 65.2848 60.4201 66.1991V77.1706C60.4201 78.0849 61.2012 78.8222 62.1325 78.8222C63.0637 78.8222 63.8147 78.0849 63.8147 77.1706V70.859C63.8147 68.883 65.2867 67.4378 67.1493 67.4378C68.8916 67.4378 70.3937 68.6765 70.3937 70.7116V77.1706C70.3937 78.0849 71.1447 78.8222 72.106 78.8222C73.0372 78.8222 73.7882 78.0849 73.7882 77.1706V70.859C73.7882 68.883 75.2602 67.4378 77.1228 67.4378C78.8651 67.4378 80.3672 68.6765 80.3672 70.7116V77.1706C80.3672 78.0849 81.1182 78.8222 82.0795 78.8222C83.0107 78.8222 83.7618 78.0849 83.7618 77.1706V70.2102C83.7317 66.4056 81.4486 64.3705 78.1441 64.3705Z" fill="black"/><path d="M92.5182 78.9697C94.1103 78.9402 95.5823 78.5863 97.0843 77.9669C97.6551 77.731 98.0757 77.1706 98.0757 76.5217C98.0757 75.6664 97.3847 74.9881 96.5136 74.9881C96.3033 74.9881 96.093 75.0176 95.9127 75.1061C94.7712 75.6075 93.6897 75.9024 92.5182 75.9024C90.6556 75.9024 89.424 74.8406 89.0034 73.2185H97.595C98.4061 73.2185 99.037 72.5697 99.037 71.8028C99.067 67.6738 96.2732 64.3705 92.2478 64.3705C88.4927 64.3705 85.4286 67.4673 85.4286 71.7733C85.4286 76.0204 88.3425 78.9992 92.5182 78.9697ZM89.0034 70.3577C89.2738 68.6176 90.7458 67.4673 92.2478 67.4673C93.7198 67.4673 95.1617 68.6471 95.4021 70.3577H89.0034Z" fill="black"/><path d="M113.424 58.8848C113.644 58.8848 113.825 58.9634 113.965 59.1207C114.125 59.2584 114.205 59.4353 114.205 59.6516C114.205 59.8482 114.125 60.0252 113.965 60.1825C113.825 60.3398 113.644 60.4184 113.424 60.4184H107.837V77.9964C107.837 78.2127 107.746 78.4093 107.566 78.5863C107.406 78.7436 107.216 78.8222 106.995 78.8222C106.775 78.8222 106.575 78.7436 106.395 78.5863C106.234 78.4093 106.154 78.2127 106.154 77.9964V60.4184H100.567C100.366 60.4184 100.186 60.3398 100.026 60.1825C99.8658 60.0252 99.7857 59.8482 99.7857 59.6516C99.7857 59.4353 99.8658 59.2584 100.026 59.1207C100.186 58.9634 100.366 58.8848 100.567 58.8848H113.424Z" fill="black"/><path d="M122.438 64.1346C123.519 64.1346 124.51 64.3804 125.412 64.8719C126.333 65.3635 127.054 66.0811 127.574 67.0249C128.115 67.949 128.386 69.0403 128.386 70.2987V78.0259C128.386 78.2422 128.305 78.429 128.145 78.5863C127.985 78.7436 127.795 78.8222 127.574 78.8222C127.354 78.8222 127.164 78.7436 127.004 78.5863C126.843 78.429 126.763 78.2422 126.763 78.0259V70.2692C126.763 68.8142 126.323 67.6738 125.442 66.848C124.56 66.0222 123.469 65.6093 122.167 65.6093C121.266 65.6093 120.455 65.8157 119.734 66.2286C119.013 66.6415 118.442 67.2215 118.022 67.9687C117.601 68.6962 117.391 69.522 117.391 70.4461V78.0259C117.391 78.2422 117.311 78.429 117.15 78.5863C116.99 78.7436 116.8 78.8222 116.58 78.8222C116.359 78.8222 116.169 78.7436 116.009 78.5863C115.849 78.429 115.768 78.2422 115.768 78.0259V58.7963C115.768 58.58 115.849 58.3932 116.009 58.2359C116.169 58.0786 116.359 58 116.58 58C116.8 58 116.99 58.0786 117.15 58.2359C117.311 58.3932 117.391 58.58 117.391 58.7963V66.7595C117.931 65.9337 118.642 65.2947 119.524 64.8424C120.405 64.3705 121.376 64.1346 122.438 64.1346Z" fill="black"/><path d="M137.328 78.9992C136.046 78.9992 134.874 78.6748 133.813 78.0259C132.771 77.3574 131.94 76.4628 131.319 75.342C130.719 74.2016 130.418 72.9432 130.418 71.5669C130.418 70.1512 130.719 68.883 131.319 67.7623C131.94 66.6219 132.771 65.7371 133.813 65.1079C134.854 64.459 136.006 64.1346 137.268 64.1346C138.609 64.1346 139.801 64.4787 140.842 65.1669C141.904 65.855 142.715 66.7988 143.276 67.9982C143.856 69.1779 144.137 70.4756 144.117 71.8913C144.117 72.0879 144.047 72.2649 143.906 72.4222C143.766 72.5598 143.586 72.6286 143.366 72.6286H132.161C132.381 74.064 132.972 75.2437 133.933 76.1678C134.894 77.0723 136.036 77.5245 137.358 77.5245C138.279 77.5245 139.1 77.3869 139.821 77.1116C140.542 76.8363 141.363 76.4333 142.284 75.9024C142.384 75.8237 142.515 75.7844 142.675 75.7844C142.895 75.7844 143.075 75.8631 143.216 76.0204C143.376 76.158 143.456 76.3251 143.456 76.5217C143.456 76.797 143.326 77.0133 143.065 77.1706C142.044 77.7605 141.093 78.2127 140.211 78.5273C139.35 78.8419 138.389 78.9992 137.328 78.9992ZM142.434 71.154C142.374 70.0922 142.104 69.1386 141.623 68.2931C141.163 67.4477 140.542 66.789 139.761 66.3171C139 65.8452 138.169 65.6093 137.268 65.6093C136.366 65.6093 135.525 65.8452 134.744 66.3171C133.983 66.789 133.362 67.4477 132.882 68.2931C132.421 69.1386 132.161 70.0922 132.101 71.154H142.434Z" fill="black"/><path d="M163.811 64.1346C164.892 64.1346 165.883 64.3804 166.785 64.8719C167.706 65.3635 168.427 66.0811 168.948 67.0249C169.488 67.949 169.759 69.0403 169.759 70.2987V78.0259C169.759 78.2422 169.679 78.429 169.518 78.5863C169.358 78.7436 169.168 78.8222 168.948 78.8222C168.727 78.8222 168.537 78.7436 168.377 78.5863C168.217 78.429 168.136 78.2422 168.136 78.0259V70.2692C168.136 68.8142 167.696 67.6738 166.815 66.848C165.933 66.0222 164.842 65.6093 163.54 65.6093C162.639 65.6093 161.828 65.8157 161.107 66.2286C160.386 66.6415 159.815 67.2215 159.395 67.9687C158.974 68.6962 158.764 69.522 158.764 70.4461V78.0259C158.764 78.2422 158.684 78.429 158.523 78.5863C158.363 78.7436 158.173 78.8222 157.953 78.8222C157.732 78.8222 157.542 78.7436 157.382 78.5863C157.222 78.429 157.142 78.2422 157.142 78.0259V70.2692C157.142 68.8142 156.701 67.6738 155.82 66.848C154.939 66.0222 153.847 65.6093 152.545 65.6093C151.644 65.6093 150.833 65.8157 150.112 66.2286C149.391 66.6415 148.82 67.2215 148.4 67.9687C147.979 68.6962 147.769 69.522 147.769 70.4461V78.0259C147.769 78.2422 147.689 78.429 147.529 78.5863C147.368 78.7436 147.178 78.8222 146.958 78.8222C146.737 78.8222 146.547 78.7436 146.387 78.5863C146.227 78.429 146.147 78.2422 146.147 78.0259V65.1079C146.147 64.8916 146.227 64.7048 146.387 64.5475C146.547 64.3902 146.737 64.3116 146.958 64.3116C147.178 64.3116 147.368 64.3902 147.529 64.5475C147.689 64.7048 147.769 64.8916 147.769 65.1079V66.7595C148.31 65.9337 149.021 65.2947 149.902 64.8424C150.783 64.3705 151.754 64.1346 152.816 64.1346C153.997 64.1346 155.069 64.4295 156.03 65.0194C156.991 65.6093 157.712 66.4252 158.193 67.4673C158.694 66.4449 159.445 65.6387 160.446 65.0489C161.447 64.4394 162.569 64.1346 163.811 64.1346Z" fill="black"/><path d="M178.71 78.9992C177.428 78.9992 176.256 78.6748 175.195 78.0259C174.154 77.3574 173.323 76.4628 172.702 75.342C172.101 74.2016 171.8 72.9432 171.8 71.5669C171.8 70.1512 172.101 68.883 172.702 67.7623C173.323 66.6219 174.154 65.7371 175.195 65.1079C176.236 64.459 177.388 64.1346 178.65 64.1346C179.992 64.1346 181.183 64.4787 182.225 65.1669C183.286 65.855 184.097 66.7988 184.658 67.9982C185.239 69.1779 185.519 70.4756 185.499 71.8913C185.499 72.0879 185.429 72.2649 185.289 72.4222C185.149 72.5598 184.968 72.6286 184.748 72.6286H173.543C173.763 74.064 174.354 75.2437 175.315 76.1678C176.277 77.0723 177.418 77.5245 178.74 77.5245C179.661 77.5245 180.482 77.3869 181.203 77.1116C181.924 76.8363 182.745 76.4333 183.667 75.9024C183.767 75.8237 183.897 75.7844 184.057 75.7844C184.277 75.7844 184.458 75.8631 184.598 76.0204C184.758 76.158 184.838 76.3251 184.838 76.5217C184.838 76.797 184.708 77.0133 184.448 77.1706C183.426 77.7605 182.475 78.2127 181.594 78.5273C180.733 78.8419 179.771 78.9992 178.71 78.9992ZM183.817 71.154C183.757 70.0922 183.486 69.1386 183.006 68.2931C182.545 67.4477 181.924 66.789 181.143 66.3171C180.382 65.8452 179.551 65.6093 178.65 65.6093C177.749 65.6093 176.907 65.8452 176.126 66.3171C175.365 66.789 174.744 67.4477 174.264 68.2931C173.803 69.1386 173.543 70.0922 173.483 71.154H183.817Z" fill="black"/></svg>';
			break;
	
			case 'gototop':
				return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.5 6.83366L12 3.16699L8.5 6.83366" stroke="white" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 20.6663L12 3.33301" stroke="white" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
			break;
	
			case 'search-toggle':
				return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.16634 3.95801C6.28986 3.95801 3.95801 6.28986 3.95801 9.16634C3.95801 12.0428 6.28986 14.3747 9.16634 14.3747C12.0428 14.3747 14.3747 12.0428 14.3747 9.16634C14.3747 6.28986 12.0428 3.95801 9.16634 3.95801Z" stroke="white" stroke-width="1.5"/><path d="M16.042 16.042L12.917 12.917" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg>';
			break;
	
			case 'woo-user':
				return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.7087 6.66634C12.7087 8.16212 11.4961 9.37467 10.0003 9.37467C8.50458 9.37467 7.29199 8.16212 7.29199 6.66634C7.29199 5.17057 8.50458 3.95801 10.0003 3.95801C11.4961 3.95801 12.7087 5.17057 12.7087 6.66634Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.70635 16.042H14.2939C15.2455 16.042 15.9785 15.2237 15.534 14.3823C14.8804 13.1446 13.3901 11.667 10.0001 11.667C6.61011 11.667 5.11982 13.1446 4.46613 14.3823C4.02174 15.2237 4.75476 16.042 5.70635 16.042Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
			break;
	
			case 'woo-cart':
				return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.45801 6.45801L5.83301 3.95801H3.95801M6.45801 6.45801H16.0413L14.677 12.2564C14.4998 13.0093 13.8281 13.5413 13.0547 13.5413H9.61592C8.85967 13.5413 8.19823 13.0322 8.00472 12.3012L6.45801 6.45801Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.75033 15.8337C8.75033 16.0637 8.56374 16.2503 8.33366 16.2503C8.10354 16.2503 7.91699 16.0637 7.91699 15.8337C7.91699 15.6036 8.10354 15.417 8.33366 15.417C8.56374 15.417 8.75033 15.6036 8.75033 15.8337Z" stroke="white"/><path d="M14.5833 15.8337C14.5833 16.0637 14.3968 16.2503 14.1667 16.2503C13.9366 16.2503 13.75 16.0637 13.75 15.8337C13.75 15.6036 13.9366 15.417 14.1667 15.417C14.3968 15.417 14.5833 15.6036 14.5833 15.8337Z" stroke="white"/></svg>';
			break;
	
			case 'pagination-prev':
				return '<svg width="28" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 1L1 6.25l5.5 5.25M27.25 6.25h-26" stroke="var(--st-heading-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
			break;
				
			case 'pagination-next':
				return '<svg width="28" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.75 1l5.5 5.25-5.5 5.25M27 6.25H1" stroke="var(--st-heading-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
			break;
		}
	}
	endif;

/**
 * Implement Local Font Method functions.
 */
require get_template_directory() . '/inc/class-webfont-loader.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Add Custom Meta Box
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Add Custom Meta Box
 */
require get_template_directory() . '/inc/getting-started/getting-started.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Upgrade Pro
*/
require get_template_directory() . '/inc/upgrade/class-upgrade.php';