<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Sublime_Blog
*/

if ( ! function_exists( 'sublime_blog_posted_on' ) ){
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function sublime_blog_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="dateModified">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		echo '<span class="posted-on"><i class="fas fa-calendar-alt"></i><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'; // WPCS: XSS OK.

	}
}

if ( ! function_exists( 'sublime_blog_posted_by' ) ){
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function sublime_blog_posted_by() {
		global $post;

		if( is_single() ){
			$author_name = get_the_author_meta( 'display_name', $post->post_author );
        	$author_id   = get_the_author_meta( 'ID', $post->post_author );
		}else{
			$author_name = get_the_author();
        	$author_id   = get_the_author_meta( 'ID' );
		}
		
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'By %s', 'post author', 'sublime-blog' ),
			'<span itemprop="name"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '" itemprop="url">' . esc_html( $author_name ) . '</span></a>'
		);

		echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person"><span class="author"> ' . get_avatar( $author_id, 206 ) . $byline . '</span></span>'; // WPCS: XSS OK.

	}
}

if( ! function_exists( 'sublime_blog_post_categories' ) ){
	/**
	 * Prints post categories
	 */
	function sublime_blog_post_categories(){
		// Hide category text for pages.
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( ' ' );
			if ( $categories_list ) {
				echo '<span class="category" itemprop="about">' . $categories_list . '</span>'; // WPCS: XSS OK.
			}
		}
	}
}

if( ! function_exists( 'sublime_blog_post_comment' ) ){
	/**
	 * Prints comments count
	 */
	function sublime_blog_post_comment(){
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fas fa-comment-alt"></i>';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'sublime-blog' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'sublime_blog_entry_footer' ) ){
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function sublime_blog_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$tags_list = get_the_tag_list( '', ' ' );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="tags" itemprop="about">' . esc_html__( '%1$sTags:%2$s %3$s', 'sublime-blog' ) . '</div>', '<span>', '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
		
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'sublime-blog' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
}

if ( ! function_exists( 'sublime_blog_post_thumbnail' ) ){
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function sublime_blog_post_thumbnail() {
		global $post;
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		$sidebar_layout = get_post_meta( $post->ID, '_sublime_blog_sidebar_layout', true );
		if( is_active_sidebar( 'sidebar' ) && $sidebar_layout == 'right-sidebar' ){
			$image_size = 'sublime-blog-featured';
		}else{
			$image_size = 'sublime-blog-slider';
		}

		if ( is_singular() ) : ?>

			<figure class="post-thumbnail">
				<?php the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) ); ?>
			</figure><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
				the_post_thumbnail( $image_size, 
					array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
						'itemprop' => 'image'
					) 
				);
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
}

if( ! function_exists( 'sublime_blog_navigation()' ) ){
	/**
	 * Single Post Navigation
	 */
	function sublime_blog_navigation(){
		if( is_single() ){
			$previous = get_previous_post_link(
				'<div class="nav-previous">%link</div>',
				'<i class="fas fa-arrow-left"></i><span class="nav-text">' . esc_html__( 'Previous Post', 'sublime-blog' ) . '</span><h3 class="nav-title">%title</h3>',
				false,
				'',
				'category'
			);
		
			$next = get_next_post_link(
				'<div class="nav-next">%link</div>',
				'<i class="fas fa-arrow-right"></i><span class="nav-text">' . esc_html__( 'Next Post', 'sublime-blog' ) . '</span><h3 class="nav-title">%title</h3>',
				false,
				'',
				'category'
			); 
			
			if( $previous || $next ){?>            
				<nav class="navigation post-navigation" role="navigation">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'sublime-blog' ); ?></h2>
					<div class="nav-links">
						<?php
							if( $previous ) echo $previous; // WPCS: XSS OK.
							if( $next ) echo $next; // WPCS: XSS OK.
						?>
					</div>
				</nav>        
				<?php
			}
		}else{
			the_posts_pagination( array(
				'prev_text'          => '<i class="fas fa-chevron-left"></i>',
				'next_text'          => '<i class="fas fa-chevron-right"></i>',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'sublime-blog' ) . ' </span>',
			) );
		}
	}
}

if( ! function_exists( 'sublime_blog_theme_comment' ) ){
	/**
	 * Callback function for Comment List *
	 * 
	 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
	 */
	function sublime_blog_theme_comment( $comment, $args, $depth ){
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		} ?>
		<<?php echo $tag; //WPCS: XSS OK. ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		
		<?php if ( 'div' != $args['style'] ) : ?>
		<article id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
		<?php endif; ?>
			
			<footer class="comment-meta">
				<div class="comment-author vcard">
				   	<?php 
						if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); 
				   		printf( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b>', get_comment_author_link() ); 
				   	?>
				</div><!-- .comment-author vcard -->
				<div class="comment-metadata commentmetadata">
					<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
						<time itemprop="commentTime" datetime="<?php echo esc_attr( get_gmt_from_date( get_comment_date() . get_comment_time(), 'Y-m-d H:i:s' ) ); ?>"><?php echo esc_html( get_comment_date() ); ?></time>
					</a>
				</div><!-- .comment-metadata -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.', 'sublime-blog' ); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->
			
			<div class="comment-content" itemprop="commentText"><?php comment_text(); ?></div>        

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>

		<?php if ( 'div' != $args['style'] ) : ?>
		</article><!-- .comment-body -->
		<?php endif; ?>
		
	<?php
	}
}

if( ! function_exists( 'sublime_blog_get_categories' ) ){
	/**
	 * Function to list post categories in customizer options
	*/
	function sublime_blog_get_categories(){ 
		$categories = array();
		
		$args = array( 
			'hide_empty' => false,
			'taxonomy'   => 'category' 
		);
		
		$catlists = get_terms( $args );
		
		$categories[''] = __( 'Choose Category', 'sublime-blog' );
		
		foreach( $catlists as $category ){
			$categories[$category->term_id] = $category->name;
		}
		
		return $categories;
	}
}

if( ! function_exists( 'sublime_blog_sidebar_layout' ) ){
	/**
	 * Return sidebar layouts for pages
	*/
	function sublime_blog_sidebar_layout(){
		global $post;
		
		if( ! empty( $post ) ){
			$sidebar_layout = get_post_meta( $post->ID, '_sublime_blog_sidebar_layout', true );
			if( $sidebar_layout ){
				return $sidebar_layout;    
			}else{
				return 'right-sidebar';
			}
		}
	}
}

if ( ! function_exists( 'wp_body_open' ) ){
	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}