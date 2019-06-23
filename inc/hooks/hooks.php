<?php 
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	/**
	 *
	 * Before Wrapper
	 *
	 * @Preloader
	 *
	 */
	add_action( 'philosophy_preloader', 'philosophy_site_preloader', 10 );

	/**
	 * Header
	 *
	 * @Header Menu
	 * @Header Bottom
	 * 
	 */

	add_action( 'philosophy_header', 'philosophy_header_cb', 10 );

	/**
	 * Hook for footer
	 *
	 */
	add_action( 'philosophy_footer', 'philosophy_footer_area', 10 );

	/**
	 * Hook for Blog, single, page, search, archive pages wrapper.
	 */
	add_action( 'philosophy_wrp_start', 'philosophy_wrp_start_cb', 10 );
	add_action( 'philosophy_wrp_end', 'philosophy_wrp_end_cb', 10 );
	
	/**
	 * Hook for Blog, single, search, archive pages column.
	 */
	add_action( 'philosophy_blog_col_start', 'philosophy_blog_col_start_cb', 10 );
	add_action( 'philosophy_blog_col_end', 'philosophy_blog_col_end_cb', 10 );
	
	/**
	 * Hook for blog posts thumbnail.
	 */
	add_action( 'philosophy_blog_posts_thumb', 'philosophy_blog_posts_thumb_cb', 10 );

	/**
	 * Hook for blog posts title.
	 */
	add_action( 'philosophy_blog_posts_title', 'philosophy_blog_posts_title_cb', 10 );

	/**
	 * Hook for blog posts meta.
	 */
	add_action( 'philosophy_blog_posts_meta', 'philosophy_blog_posts_meta_cb', 10 );

	/**
	 * Hook for blog posts excerpt.
	 */
	add_action( 'philosophy_blog_posts_excerpt', 'philosophy_blog_posts_excerpt_cb', 10 );

	/**
	 * Hook for blog pagination.
	 */
	add_action( 'philosophy_blog_pagination', 'philosophy_blog_pagination_cb', 10 );


	/**
	 * Hook for blog posts content.
	 */
	add_action( 'philosophy_blog_posts_content', 'philosophy_blog_posts_content_cb', 10 );

	/**
	 * Hook for blog sidebar.
	 */
	add_action( 'philosophy_blog_sidebar', 'philosophy_blog_sidebar_cb', 10 );
	
	/**
	 * Hook for blog single post social share option.
	 */
	add_action( 'philosophy_blog_posts_share', 'philosophy_blog_posts_share_cb', 10 );
	
	/**
	 * Hook for blog single post meta category, tag, next - previous link and comments form.
	 */
	add_action( 'philosophy_blog_single_meta', 'philosophy_blog_single_meta_cb', 10 );
	
	/**
	 * Hook for page content.
	 */
	add_action( 'philosophy_page_content', 'philosophy_page_content_cb', 10 );
	
	
	/**
	 * Hook for 404 page.
	 */
	add_action( 'philosophy_fof', 'philosophy_fof_cb', 10 );

	

?>