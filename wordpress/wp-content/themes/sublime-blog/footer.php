<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sublime_Blog
 */
?>
		</div><!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
		<?php
			if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ){
				echo '<div class="top-footer"><div class="container"><div class="footer-grid column-three">';
				if( is_active_sidebar( 'footer-one' ) ){
					echo '<div class="footer-col">';
					dynamic_sidebar( 'footer-one' );
					echo '</div><!-- .footer-col -->';
				}
				if( is_active_sidebar( 'footer-two' ) ){
					echo '<div class="footer-col">';
					dynamic_sidebar( 'footer-two' );
					echo '</div><!-- .footer-col -->';
				}
				if( is_active_sidebar( 'footer-three' ) ){
					echo '<div class="footer-col">';
					dynamic_sidebar( 'footer-three' );
					echo '</div><!-- .footer-col -->';
				}
				echo '</div><!-- .footer-grid --></div><!-- .container --></div><!-- .top-footer -->';
			}
		?>
		<div class="bottom-footer">
			<div class="container">
				<?php
					sublime_blog_footer_copyright();
				?>	
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'sublime-blog' ) ); ?>">
					<?php
						/* translators: %s: CMS name, i.e. WordPress. */
						printf( esc_html__( 'Proudly powered by %s', 'sublime-blog' ), 'WordPress' );
					?>
				</a>
				<?php 
					if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link();
					}
				?>
			</div>
		</div><!-- .bottom-footer -->
		<button class="goto-top">
			<i class="fas fa-arrow-up"></i><span><?php esc_html_e( 'Top', 'sublime-blog' ); ?></span>
		</button><!-- .goto-top -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>