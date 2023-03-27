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

	<footer class="site-footer">
		<div class="bottom-footer">
			<div class="container">
					<?php
						sublime_blog_footer_copyright();
					?>
					<span class="copyright year">
						<?php
							echo currentYear();
						?>
					</span>
			</div>
		</div><!-- .bottom-footer -->
		<button class="goto-top static">
			<i class="fas fa-arrow-up"></i>
		</button><!-- .goto-top -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>