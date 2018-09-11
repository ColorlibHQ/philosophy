<?php 
/**
 * @Packge 	   : Philosophy
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 *
 * Template Name: Builder Template
 */
 
 get_header();


	if( have_posts() ){
		while( have_posts() ){
			the_post();
			
			the_content();
		}
	}
 
 get_footer();
?>