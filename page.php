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

	//  Call Header
	get_header();

	/**
	 * 
	 * Hook for Blog, single, page, search, archive pages
	 * wrapper start with wrapper div, container, row.
	 *
	 * Hook philosophy_wrp_start
	 *
	 * @Hooked philosophy_wrp_start_cb
	 *  
	 */
	do_action( 'philosophy_wrp_start' );
	

	if( have_posts() ){
		while( have_posts() ){
			the_post();
			// Post Contant
			get_template_part( 'templates/content', 'page' );
		}
		// Reset Data
		wp_reset_postdata();
	}else{
		get_template_part( 'templates/content', 'none' );
	}
 	
 	/**
	 * Hook for Blog, single, page, search, archive pages
	 * wrapper end with wrapper div, container, row.
 	 *
 	 * Hook philosophy_wrp_end
 	 * @Hooked  philosophy_wrp_end_cb
 	 *
 	 */
 	do_action( 'philosophy_wrp_end' );
 	
	 // Call Footer
	 get_footer();
?>