<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sublime_Blog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<?php wp_body_open(); ?> 
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'sublime-blog' ); ?></a>
	<div class="header-banner-wrap">
		<?php sublime_blog_header(); ?>
		<?php sublime_blog_slider(); ?>
	</div><!-- .header-banner-wrap -->

	<div id="content" class="site-content">
		<?php if( ! is_front_page() ){ ?>
			<header class="page-header">
				<div class="container">
					<?php 
						if( is_home() ){
							echo '<h1 class="page-title">';
							single_post_title();
							echo '</h1>';
						}

						if( is_archive() ){
							the_archive_title();
                    		the_archive_description( '<div class="archive-description">', '</div>' );
						}

						if( is_search() ){
							echo '<h1 class="screen-reader-text">' . esc_html__( 'Search Result', 'sublime-blog' ) . '</h1>';
							echo '<span class="sub-title">' . esc_html__( 'Search results for the keyword:', 'sublime-blog' ) . '</span>';
							get_search_form();
						}

						if( is_404() ){
							echo '<h1 class="page-title">' . esc_html__( 'Oop! This page can not be found', 'sublime-blog' ) . '</h1>';
						}

						if( is_singular() ){
							sublime_blog_post_categories();

							the_title( '<h1 class="page-title">', '</h1>' );
							
							if( 'post' == get_post_type() ){
								echo '<div class="entry-meta">';
								sublime_blog_posted_by();
								sublime_blog_posted_on();
								sublime_blog_post_comment();								
								echo '</div><!-- .entry-meta -->';
							}
						}
					?>
				</div><!-- .container -->
			</header><!-- .page-header -->
		<?php } ?>
		<div class="container">
