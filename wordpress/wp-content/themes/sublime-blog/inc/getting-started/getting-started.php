<?php 
/**
 * Getting Started
 * 
 * @package Sublime_Blog
 */

if( ! function_exists( 'sublime_blog_theme_page' ) ):
function sublime_blog_theme_page() {
    add_theme_page( __( 'Getting Started','sublime-blog' ), __( 'Getting Started','sublime-blog' ), 'manage_options', 'sublime-blog-theme-options', 'sublime_blog_getting_started_page' );
}
endif;
add_action( 'admin_menu', 'sublime_blog_theme_page' );

if( ! function_exists( 'sublime_blog_getting_started_page' ) ) :
function sublime_blog_getting_started_page() { ?>
    <div class="st-gs-outer-wrapper">
		<div class="st-gs-inner-wrapper">
			<div class="st-gs-header">
				<div class="st-gs-header-logo">
					<?php echo sublime_blog_svg_collection( 'sublime' ); ?>					
				</div>
				<p class="st-gs-subtitle"><?php esc_html_e( 'Simple, Easy, and Fast WordPress Theme.','sublime-blog' ); ?></p>
			</div>
			<div class="st-gs-tab-holder">
				<ul>
					<li>
						<button class="st-gs-tab gs-dashboard active"><?php esc_html_e( 'Dashboard','sublime-blog' ); ?></button>
					</li>
                    <li>
						<button class="st-gs-tab gs-free-vs-pro"><?php esc_html_e( 'Free vs Pro', 'sublime-blog' ); ?></button>
					</li>
				</ul>
			</div>
			<div class="st-gs-main">
				<div class="st-gs-tab-content-holder">
                    <?php 
                        require get_template_directory() . '/inc/getting-started/tabs/dashboard.php';
                        require get_template_directory() . '/inc/getting-started/tabs/free-vs-pro.php';
                    ?>
				</div>
			</div>
			<div class="st-gs-aside">
                <?php require get_template_directory() . '/inc/getting-started/tabs/knowledge.php'; ?>
			</div>
		</div>
	</div><!-- .st-gs-outer-wrapper -->
    <?php 
}
endif;

if( ! function_exists( 'sublime_blog_getting_started_scripts' ) ) :
/**
 * Load Getting Started styles in the admin
 */
function sublime_blog_getting_started_scripts( $hook ){
    // Load styles only on our page
    if( 'appearance_page_sublime-blog-theme-options' != $hook ) return;

    wp_enqueue_style( 'sublime-blog-getting-started', get_template_directory_uri() . '/inc/getting-started/css/getting-started.css', false, SUBLIME_BLOG_VERSION );

    wp_enqueue_script( 'sublime-blog-getting-started', get_template_directory_uri() . '/inc/getting-started/js/getting-started.js', array( 'jquery' ), SUBLIME_BLOG_VERSION, true );

    wp_enqueue_script( 'sublime-blog-recommended-plugin-install', get_template_directory_uri() . '/inc/getting-started/js/recommended-plugin-install.js', array( 'jquery','plugin-install','wp-util','updates' ), SUBLIME_BLOG_VERSION, true );    
    $localize = array(
        'ajaxUrl'              => admin_url( 'admin-ajax.php' ),
        'ActivatingText'       => __( 'Activating', 'sublime-blog' ),
        'DeactivatingText'     => __( 'Deactivating', 'sublime-blog' ),
        'PluginActivateText'   => __( 'Activate', 'sublime-blog' ),
        'PluginDeactivateText' => __( 'Deactivate', 'sublime-blog' ),
        'SettingsText'         => __( 'Settings', 'sublime-blog' ),
    );  
    wp_localize_script( 'sublime-blog-recommended-plugin-install', 'sublime_blog_page', $localize );
}
endif;
add_action( 'admin_enqueue_scripts', 'sublime_blog_getting_started_scripts' );

if( ! function_exists( 'sublime_blog_call_plugin_api' ) ) :
/**
 * Plugin API
**/
function sublime_blog_call_plugin_api( $plugin ) {
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    $call_api = plugins_api( 
        'plugin_information', 
            array(
            'slug'   => $plugin,
            'fields' => array(
                'downloaded'        => false,
                'rating'            => false,
                'description'       => false,
                'short_description' => true,
                'donate_link'       => false,
                'tags'              => false,
                'sections'          => true,
                'homepage'          => true,
                'added'             => false,
                'last_updated'      => false,
                'compatibility'     => false,
                'tested'            => false,
                'requires'          => false,
                'downloadlink'      => false,
                'icons'             => true
            )
        ) 
    );
    return $call_api;
}
endif;

if( ! function_exists( 'sublime_blog_required_plugin_activate' ) ) :
/**
 * Required Plugin Activate
 */
function sublime_blog_required_plugin_activate() {

	if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
		wp_send_json_error(
			array(
				'success' => false,
				'message' => __( 'No plugin specified', 'sublime-blog' ),
			)
		);
	}

	$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

	$activate = activate_plugin( $plugin_init, '', false, true );

	if ( is_wp_error( $activate ) ) {
		wp_send_json_error(
			array(
				'success' => false,
				'message' => $activate->get_error_message(),
			)
		);
	}

	wp_send_json_success(
		array(
			'success' => true,
			'message' => __( 'Plugin Successfully Activated', 'sublime-blog' ),
		)
	);

}
endif;
add_action('wp_ajax_gs-sites-plugin-activate', 'sublime_blog_required_plugin_activate');
add_action('wp_ajax_nopriv_gs-sites-plugin-activate', 'sublime_blog_required_plugin_activate');
	
if( ! function_exists( 'sublime_blog_required_plugin_deactivate' ) ) :
/**
 * Required Plugin Activate
 */
function sublime_blog_required_plugin_deactivate() {
	
    if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
        wp_send_json_error(
            array(
                'success' => false,
                'message' => __( 'No plugin specified', 'sublime-blog' ),
            )
        );
    }

    $plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

    $deactivate = deactivate_plugins( $plugin_init, '', false );

    if ( is_wp_error( $deactivate ) ) {
        wp_send_json_error(
            array(
                'success' => false,
                'message' => $deactivate->get_error_message(),
            )
        );
    }

    wp_send_json_success(
        array(
            'success' => true,
            'message' => __( 'Plugin Successfully Deactivated', 'sublime-blog' ),
        )
    );

}
endif;
add_action('wp_ajax_gs-sites-plugin-deactivate', 'sublime_blog_required_plugin_deactivate');
add_action('wp_ajax_nopriv_gs-sites-plugin-deactivate', 'sublime_blog_required_plugin_deactivate');
	
if( ! function_exists( 'sublime_blog_check_for_icon' ) ) :
/**
 * Check For Icon 
**/
function sublime_blog_check_for_icon( $arr ) {
    if( ! empty( $arr['svg'] ) ){
        $plugin_icon_url = $arr['svg'];
    }elseif( ! empty( $arr['2x'] ) ){
        $plugin_icon_url = $arr['2x'];
    }elseif( ! empty( $arr['1x'] ) ){
        $plugin_icon_url = $arr['1x'];
    }else{
        $plugin_icon_url = $arr['default'];
    }                               
    return $plugin_icon_url;
}
endif;