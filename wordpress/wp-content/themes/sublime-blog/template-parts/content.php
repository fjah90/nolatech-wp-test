<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Sublime_Blog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

			if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
						sublime_blog_posted_by();
						sublime_blog_posted_on();
						sublime_blog_post_comment();
					?>
				</div><!-- .entry-meta -->
				<?php 
			endif; 
		?>
	</header><!-- .entry-header -->

	<?php sublime_blog_post_thumbnail(); ?>
	
	<div class="entry-content" itemprop="text">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->
	
	<div class="button-wrap">
		<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Continue Reading', 'sublime-blog' ); ?></a>
	</div>

	<footer class="entry-footer">
		<?php sublime_blog_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->