<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Sublime_Blog
*/

if( ! function_exists( 'sublime_blog_header' ) ){
	/**
	 * Sublime Blog Header
	 *
	 * @return array
	 */
	function sublime_blog_header(){
		?>
		<header id="masthead" class="site-header" itemscope itemtype="http://schema.org/WPHeader">
			<div class="top-header">
				<div class="container">
					<div class="site-branding" itemscope itemtype="http://schema.org/Organization">
						<?php the_custom_logo(); ?>

						<div class="site-title-wrap">
							<?php
							if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
								<?php
							else : ?>
								<p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							endif;
							$sublime_blog_description = get_bloginfo( 'description', 'display' );
							if ( $sublime_blog_description || is_customize_preview() ) : ?>
								<p class="site-description" itemprop="description"><?php echo $sublime_blog_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>
						</div>
					</div><!-- .site-branding -->
					<?php if( get_theme_mod( 'ed_header_search',true ) ) : ?>				
						<div class="header-left">
							<div class="header-search">
								<?php get_search_form(); ?>
							</div><!-- .header-search -->
						</div><!-- .header-left -->
					<?php endif; ?>
				</div><!-- .container -->
			</div><!-- .top-header -->
			<div class="nav-wrap">
				<div class="container">					
					<nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
						<button class="toggle-button" aria-controls="primary-menu" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
							<span class="toggle-bar"></span>
							<span class="toggle-bar"></span>
							<span class="toggle-bar"></span>
							<span class="toggle-text"><?php esc_html_e( 'Primary Menu', 'sublime-blog' ); ?></span>
						</button><!-- .toggle-button -->
						<div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
		                    <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal">
		                    	<span class="toggle-bar"></span>
								<span class="toggle-text"><?php esc_html_e( 'Close', 'sublime-blog' ); ?></span>
		                    </button>
		                    <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'sublime-blog' ); ?>">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu',
										'menu_class'	 => 'menu main-menu-modal'
									) );
								?>
							</div>
						</div>
					</nav><!-- #site-navigation -->
				</div><!-- .container -->
			</div><!-- .nav-wrap -->
		</header><!-- #masthead -->
		<?php 
	}
}

if( ! function_exists( 'sublime_blog_slider' ) ){
	/**
	 * Sublime Blog Slider
	 *
	 */
	function sublime_blog_slider(){
		if( is_front_page() ){
			$ed_slider      = get_theme_mod( 'ed_slider_section', false );
			$slider_type    = get_theme_mod( 'slider_type', 'latest_posts' );
			$slider_cat     = get_theme_mod( 'slider_cat' );
			$posts_per_page = get_theme_mod( 'no_of_slides', 3 );
			if( $ed_slider ){
				$slider_arg = array(
					'post_type'           => 'post',
					'post_status'         => 'publish',            
					'ignore_sticky_posts' => true
				);

				if( $slider_type === 'cat' && $slider_cat ){
					$slider_arg['cat']            = $slider_cat; 
					$slider_arg['posts_per_page'] = -1;  
				}else{
					$slider_arg['posts_per_page'] = $posts_per_page;
				}

				$slider_qry = new WP_Query( $slider_arg );
				
				if( $slider_qry->have_posts() ){
					echo '<div class="site-banner"><div class="container"><div class="banner-items owl-carousel">';
					while( $slider_qry->have_posts() ){
						$slider_qry->the_post();
						if( has_post_thumbnail() ){ ?>
							<div class="banner-item">
								<?php the_post_thumbnail( 'sublime-blog-slider', array( 'itemprop' => 'image' ) ); ?>
								<div class="item-content">
									<div class="item-content-inner">
										<?php 
											/* translators: used between list items, there is a space after the comma */
											$categories_list = get_the_category_list( esc_html__( ', ', 'sublime-blog' ) );
											if( $categories_list ) printf( '<span class="category" itemprop="about">%1$s</span>', $categories_list ); // WPCS: XSS OK.
											the_title( '<h2 class="item-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
										?>
									</div>
								</div>
							</div><!-- .banner-item -->
							<?php
						}
					}
					echo '</div><!-- .banner-items --></div><!-- .container --></div><!-- .site-banner -->';
					wp_reset_postdata();
				} 
			}
		} 
	}
}

if( ! function_exists( 'sublime_blog_body_classes' ) ){
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function sublime_blog_body_classes( $classes ) {
		global $post;
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}
		if( is_active_sidebar( 'sidebar' ) ){

			if( is_home() || is_archive() || is_search() ){
				$classes[] = 'classic-layout rightsidebar';
			}
		
			if( is_singular() ){
				$sidebar_layout = get_post_meta( $post->ID, '_sublime_blog_sidebar_layout', true );
				if( $sidebar_layout == 'no-sidebar' ){
					$classes[] = 'fullwidth';
				}else{
					$classes[] = 'rightsidebar';
				}
			}
		}else{
			$classes[] = 'fullwidth';
		}

		if( is_404() ){
			$classes[] = 'fullwidth';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'sublime_blog_body_classes' );

if( ! function_exists( 'sublime_blog_pingback_header' ) ){
	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function sublime_blog_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
}
add_action( 'wp_head', 'sublime_blog_pingback_header' );

if( ! function_exists( 'sublime_blog_archive_title' ) ){
	/**
	 * Filter the archive title
	 */
	function sublime_blog_archive_title(){
		if( is_category() ){
			/* translators: Category archive title. 1: Category name */
			$title = sprintf( __( '%1$sCategory%2$s %3$s', 'sublime-blog' ), '<span class="sub-title">', '</span>', '<h1 class="page-title">' . single_cat_title( '', false ) . '</h1>' );
		}elseif ( is_tag() ){
			/* translators: Tag archive title. 1: Tag name */
			$title = sprintf( __( '%1$sTag%2$s %3$s', 'sublime-blog' ), '<span class="sub-title">', '</span>', '<h1 class="page-title">' . single_tag_title( '', false ) . '</h1>' );
		}elseif( is_author() ){
			/* translators: Author archive title. 1: Author name */
			$title = sprintf( __( '%1$sAuthor%2$s %3$s', 'sublime-blog' ), '<span class="sub-title">', '</span>', '<h1 class="page-title">' . get_the_author() . '</h1>' );
		}elseif ( is_year() ) {
			/* translators: Yearly archive title. 1: Year */
			$title = sprintf( __( '%1$sYear%2$s %3$s', 'sublime-blog' ), '<span class="sub-title">', '</span>', '<h1 class="page-title">' . get_the_date( _x( 'Y', 'yearly archives date format', 'sublime-blog' ) ) . '</h1>' );
		}elseif ( is_month() ) {
			/* translators: Monthly archive title. 1: Month name and year */
			$title = sprintf( __( '%1$sMonth%2$s %3$s', 'sublime-blog' ), '<span class="sub-title">', '</span>', '<h1 class="page-title">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'sublime-blog' ) ) . '</h1>' );
		}elseif ( is_day() ) {
			/* translators: Daily archive title. 1: Date */
			$title = sprintf( __( '%1$sDay%2$s %3$s', 'sublime-blog' ), '<span class="sub-title">', '</span>', '<h1 class="page-title">' . get_the_date( _x( 'F j, Y', 'daily archives date format', 'sublime-blog' ) ) . '</h1>' );
		}elseif ( is_post_type_archive() ) {
			/* translators: Post type archive title. 1: Post type name */
			$title = sprintf( __( '%1$sArchives%2$s %3$s', 'sublime-blog' ), '<span class="sub-title">', '</span>', '<h1 class="page-title">' . post_type_archive_title( '', false ) . '</h1>' );
		}elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			$title = '<span>' . $tax->labels->singular_name . '</span><h1 class="page-title">' . single_term_title( '', false ) . '</h1>';
		}
		return $title;
	}
}
add_filter( 'get_the_archive_title', 'sublime_blog_archive_title' );

if ( ! function_exists( 'sublime_blog_excerpt_more' ) ){
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
	 */
	function sublime_blog_excerpt_more( $more ) {
		return is_admin() ? $more : ' &hellip; ';
	}
}
add_filter( 'excerpt_more', 'sublime_blog_excerpt_more' );

if( ! function_exists( 'sublime_blog_exclude_cat' ) ){
	/**
	 * Exclude posts in slider from blog page. 
	*/
	function sublime_blog_exclude_cat( $query ){
		$ed_slider      = get_theme_mod( 'ed_slider_section', false );
		$slider_type    = get_theme_mod( 'slider_type', 'latest_posts' );
		$slider_cat     = get_theme_mod( 'slider_cat' );
		$posts_per_page = get_theme_mod( 'no_of_slides', 3 );
		
		if( ! is_admin() && $query->is_main_query() && $query->is_home() && $query->is_front_page() && $ed_slider ){
			if( $slider_type === 'cat' && $slider_cat  ){            
				 $query->set( 'category__not_in', array( $slider_cat ) );    		
			}elseif( $slider_type == 'latest_posts' ){
				$args = array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => $posts_per_page,
					'ignore_sticky_posts' => true
				);
				$latest   = get_posts( $args );
				$excludes = array();
				foreach( $latest as $l ){
					array_push( $excludes, $l->ID );
				}
				$query->set( 'post__not_in', $excludes );
			}  
		}      
	}
}
add_filter( 'pre_get_posts', 'sublime_blog_exclude_cat' );

if( ! function_exists( 'sublime_blog_get_comment_author_link' ) ){
	/**
	 * Filter to modify comment author link
	 * @link https://developer.wordpress.org/reference/functions/get_comment_author_link/
	 */
	function sublime_blog_get_comment_author_link( $return, $author, $comment_ID ){
		$comment = get_comment( $comment_ID );
		$url     = get_comment_author_url( $comment );
		$author  = get_comment_author( $comment );
		
		if ( empty( $url ) || 'http://' == $url )
			$return = '<span itemprop="name">'. esc_html( $author ) .'</span>';
		else
			$return = '<span itemprop="name"><a href=' . esc_url( $url ) . ' rel="external nofollow noopener" class="url" itemprop="url">' . esc_html( $author ) . '</a></span>';

		return $return;
	}
}
add_filter( 'get_comment_author_link', 'sublime_blog_get_comment_author_link', 10, 3 );