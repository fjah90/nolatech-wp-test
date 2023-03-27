<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.5
 * @access public
 */
final class Sublime_Blog_Upgrade_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.5
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.5
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.5
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'inc/upgrade/class-upgrade-section.php' );

		// Register custom section types.
		$manager->register_section_type( 'Sublime_Blog_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Sublime_Blog_Customize_Section_Pro(
				$manager,
				'sublime_blog_pro',
				array(
					'title'    => esc_html__( 'Pro Theme Available', 'sublime-blog' ),
					'pro_text' => esc_html__( 'View Pro Theme', 'sublime-blog' ),
					'pro_url'  => esc_url( 'https://sublimetheme.com/theme/sublime-blog-pro/' ),
					'priority' => 5
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'sublime-blog-upgrade', trailingslashit( get_template_directory_uri() ) . 'inc/upgrade/upgrade.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'sublime-blog-upgrade', trailingslashit( get_template_directory_uri() ) . 'inc/upgrade/upgrade.css' );
	}
}

// Doing this customizer thang!
Sublime_Blog_Upgrade_Customize::get_instance();