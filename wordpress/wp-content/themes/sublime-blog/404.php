<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Sublime_Blog
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<div class="page-content">
					<div class="error-num"><?php esc_html_e( '404', 'sublime-blog' );?></div>
					<p><?php esc_html_e( 'The page you were looking for could not be found. You may have typed the address incorrectly or you may have used an outdated link. Try search our site.', 'sublime-blog' ); ?></p>
					<?php get_search_form(); ?>
					<a class="btn-readmore" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Homepage', 'sublime-blog' ); ?></a>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
