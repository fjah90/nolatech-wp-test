<?php
/**
 * Sublime Blog Theme Customizer
 *
 * @package Sublime_Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

/**
 * Customizer Info
*/
require get_template_directory() . '/inc/info.php';

if ( ! function_exists( 'sublime_blog_customize_register' ) ) :

function sublime_blog_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'sublime_blog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'sublime_blog_customize_partial_blogdescription',
		) );
	}

	//Header Settings
	$wp_customize->add_section(
        'header_settings',
        array(
            'title'      => __( 'Header Settings', 'sublime-blog' ),
            'priority'   => 20,
            'capability' => 'edit_theme_options',
        )
	);

	/** Enable Header Search. */
	$wp_customize->add_setting(
		'ed_header_search',
		array(
			'default'			=> true,
			'sanitize_callback' => 'sublime_blog_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(		
		'ed_header_search',
		array(
			'label'   => __( 'Enable Header Search', 'sublime-blog' ),
			'section' => 'header_settings',
			'type'    => 'checkbox'
		)            
	);
	
	/** Slider Settings */
	$wp_customize->add_section(
        'slider_settings',
        array(
            'title'      => __( 'Slider Settings', 'sublime-blog' ),
            'priority'   => 30,
            'capability' => 'edit_theme_options',
        )
    );	
	
	/** Enable banner slider. */
    $wp_customize->add_setting(
		'ed_slider_section',
		array(
			'default'			=> false,
			'sanitize_callback' => 'sublime_blog_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(		
		'ed_slider_section',
		array(
			'label'           => __( 'Enable Banner Slider', 'sublime-blog' ),
			'section'         => 'slider_settings',
			'type'            => 'checkbox',
		)            
	);

	/** Enable/Disable Slider Auto Transition */
    $wp_customize->add_setting(
        'slider_auto',
        array(
            'default' => true,
            'sanitize_callback' => 'sublime_blog_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'slider_auto',
        array(
            'label'           => __( 'Enable Slider Auto Transition', 'sublime-blog' ),
            'section'         => 'slider_settings',
            'type'            => 'checkbox',
            'active_callback' => 'sublime_blog_banner_ac'
        )
    );
    
    /** Enable/Disable Slider Loop */
    $wp_customize->add_setting(
        'slider_loop',
        array(
            'default'           => true,
            'sanitize_callback' => 'sublime_blog_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'slider_loop',
        array(
            'label'           => __( 'Enable Slider Loop', 'sublime-blog' ),
            'section'         => 'slider_settings',
            'type'            => 'checkbox',
            'active_callback' => 'sublime_blog_banner_ac'
        )
    );
    
    /** Slider Transition */
    $wp_customize->add_setting(
        'slider_animation',
        array(
            'default'           => '',
            'sanitize_callback' => 'sublime_blog_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'slider_animation',
        array(
            'label'   => __( 'Choose Slider Transition', 'sublime-blog' ),
            'section' => 'slider_settings',
            'type'    => 'select',
            'choices' => array(
                ''        => __( 'Slide', 'sublime-blog' ),
                'fadeOut' => __( 'Fade', 'sublime-blog' ),
			),
			'active_callback' => 'sublime_blog_banner_ac'
        )
    );
    
    /** Slider Speed */
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default'           => '1000',
            'sanitize_callback' => 'sublime_blog_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'slider_speed',
        array(
            'label'           => __( 'Slider Autoplay Speed', 'sublime-blog' ),
            'section'         => 'slider_settings',
            'type'            => 'number',
            'active_callback' => 'sublime_blog_banner_ac'
        )
    );
    
    /** Slider Autoplay Timeout */
    $wp_customize->add_setting(
        'slider_timeout',
        array(
            'default'           => '5000',
            'sanitize_callback' => 'sublime_blog_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'slider_timeout',
        array(
            'label'           => __( 'Slider Autoplay Timeout', 'sublime-blog' ),
            'section'         => 'slider_settings',
            'type'            => 'number',
            'active_callback' => 'sublime_blog_banner_ac'
        )
    );

	/** Slider Type */
    $wp_customize->add_setting(
		'slider_type',
		array(
			'default'			=> 'latest_posts',
			'sanitize_callback' => 'sublime_blog_sanitize_select'
		)
	);

	$wp_customize->add_control(		
		'slider_type',
		array(
			'label'   => __( 'Slider Type', 'sublime-blog' ),
			'section' => 'slider_settings',
			'choices' => array(
				'latest_posts' => __( 'Latest Posts', 'sublime-blog' ),
				'cat'          => __( 'Category', 'sublime-blog' )
			),
			'active_callback' => 'sublime_blog_banner_ac',
			'type'            => 'select',
		)
	);

	/** Slider Category */
    $wp_customize->add_setting(
		'slider_cat',
		array(
			'default'			=> '',
			'sanitize_callback' => 'sublime_blog_sanitize_select'
		)
	);

	$wp_customize->add_control(
		'slider_cat',
		array(
			'label'           => __( 'Slider Category', 'sublime-blog' ),
			'section'         => 'slider_settings',
			'type'            => 'select',
			'choices'         => sublime_blog_get_categories(),
			'active_callback' => 'sublime_blog_banner_ac'
		)
	);

	/** No. of slides */
    $wp_customize->add_setting(
        'no_of_slides',
        array(
            'default'           => 3,
            'sanitize_callback' => 'sublime_blog_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(		
		'no_of_slides',
		array(
			'section'     => 'slider_settings',
			'label'       => __( 'Number of Slides', 'sublime-blog' ),
			'description' => __( 'Choose the number of slides you want to display', 'sublime-blog' ),
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => '1',
				'step' => '1',
				'max'  => '10',
			),
			'active_callback' => 'sublime_blog_banner_ac'
		)
    );
    
    $wp_customize->add_section(
        'sublime_blog_typography_section',
        array(
            'title'      => __( 'Typography Settings', 'sublime-blog' ),
            'priority'   => 40,
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_setting(
        'ed_localgoogle_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'sublime_blog_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'ed_localgoogle_fonts',
        array(
            'label'   => __( 'Load Google Fonts Locally', 'sublime-blog' ),
            'section' => 'sublime_blog_typography_section',
            'type'    => 'checkbox',
        )
    );
    

    $wp_customize->add_setting(
        'flush_google_fonts',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        'flush_google_fonts',
        array(
            'label'       => __( 'Flush Local Fonts Cache', 'sublime-blog' ),
            'description' => __( 'Click the button to reset the local fonts cache.', 'sublime-blog' ),
            'type'        => 'button',
            'settings'    => array(),
            'section'     => 'sublime_blog_typography_section',
            'input_attrs' => array(
                'value' => __( 'Flush Local Fonts Cache', 'sublime-blog' ),
                'class' => 'button button-primary flush-it',
            ),
            'active_callback' => 'sublime_blog_flush_fonts_callback'
        )
    );

	//Footer Settings
	$wp_customize->add_section(
        'footer_settings',
        array(
            'title'      => __( 'Footer Settings', 'sublime-blog' ),
            'priority'   => 300,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'copyright',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'copyright',
        array(
            'label'   => __( 'Footer Copyright', 'sublime-blog' ),
            'section' => 'footer_settings',
            'type'    => 'textarea',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'copyright', array(
        'selector' => '.bottom-footer .copyright',
        'render_callback' => 'sublime_blog_footer_copyright',
    ) );
}
add_action( 'customize_register', 'sublime_blog_customize_register' );
endif;

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function sublime_blog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function sublime_blog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'sublime_blog_footer_copyright' ) ) :
	/**
	 * Prints footer copyright
	*/
	function sublime_blog_footer_copyright(){
		$copyright = get_theme_mod( 'copyright' );
		echo '<span class="copyright">';
		if( $copyright ){
			echo wp_kses_post( $copyright );
		} 
		echo '</span>';
        /* translators: 1: Theme name, 2: Theme author. */
        printf( esc_html__( 'Theme: %1$s by %2$s.', 'sublime-blog' ), 'Sublime Blog', '<a href="'.esc_url( 'https://sublimetheme.com/' ).'" rel="nofollow" target="_blank" >SublimeTheme</a>' );
	}
endif; 

/**
 * Customizer Control Enqueue Scripts
 *
 * @return void
 */
function sublime_blog_customize_script(){
    wp_enqueue_style( 'sublime-blog-customize-css', get_template_directory_uri() . '/inc/css/customizer.css', array(), SUBLIME_BLOG_VERSION );
    wp_enqueue_script( 'sublime-blog-customize-js', get_template_directory_uri() . '/inc/js/customizer.js', array( 'jquery', 'customize-controls' ), SUBLIME_BLOG_VERSION, true );

    $sublime_blog_array = array(
    	'ajax_url' => admin_url( 'admin-ajax.php' ),
    	'flushit'  => __( 'Successfully Flushed!','sublime-blog' ),
    	'nonce'    => wp_create_nonce('ajax-nonce')
	);
	wp_localize_script( 'sublime-blog-customize-js', 'sublime_blog_cdata', $sublime_blog_array );
}
add_action( 'customize_controls_enqueue_scripts', 'sublime_blog_customize_script' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sublime_blog_customize_preview_js() {
	wp_enqueue_script( 'sublime-blog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), SUBLIME_BLOG_VERSION, true );
}
add_action( 'customize_preview_init', 'sublime_blog_customize_preview_js' );

function sublime_blog_sanitize_checkbox( $checked ){
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function sublime_blog_sanitize_select( $value ){    
    if ( is_array( $value ) ) {
		foreach ( $value as $key => $subvalue ) {
			$value[ $key ] = sanitize_text_field( $subvalue );
		}
		return $value;
	}
	return sanitize_text_field( $value );    
}

function sublime_blog_sanitize_number_absint( $number, $setting ) {
    // Ensure $number is an absolute integer (whole number, zero or greater).
    $number = absint( $number );
    
    // If the input is an absolute integer, return it; otherwise, return the default
    return ( $number ? $number : $setting->default );
}

function sublime_blog_banner_ac( $control ){
	$ed_slider   = $control->manager->get_setting( 'ed_slider_section' )->value();
	$slider_type = $control->manager->get_setting( 'slider_type' )->value();
	$control_id  = $control->id;
	
	if( $ed_slider == true && $control_id == 'slider_auto' ) return true;
	if( $ed_slider == true && $control_id == 'slider_loop' ) return true;

	if( $ed_slider == true && $control_id == 'slider_animation' ) return true;
	if( $ed_slider == true && $control_id == 'slider_speed' ) return true;
	if( $ed_slider == true && $control_id == 'slider_timeout' ) return true;
	
	if( $ed_slider == true && $control_id == 'slider_type' ) return true;
	if( $ed_slider == true && $control_id == 'no_of_slides' ) return true;
    if( $ed_slider == true && $control_id == 'slider_cat' && $slider_type == 'cat' ) return true;
    
    return false;
}

/**
 * Active callback for Flush  Google Fonts
 */
function sublime_blog_flush_fonts_callback( $control ){
    $ed_localgoogle_fonts   = $control->manager->get_setting( 'ed_localgoogle_fonts' )->value();
    $control_id   = $control->id;
    
    if ( $control_id == 'flush_google_fonts' && $ed_localgoogle_fonts ) return true;
    return false;
}