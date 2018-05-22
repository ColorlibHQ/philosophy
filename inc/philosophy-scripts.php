<?php

/**
 * Enqueue scripts and styles.
 */
function philosophy_scripts() {

	//CSS
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri(). '/assets/css/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'philosophy-fonts', get_template_directory_uri(). '/assets/css/fonts.css' );
	wp_enqueue_style( 'base', get_template_directory_uri(). '/assets/css/base.css');
	wp_enqueue_style( 'vendor', get_template_directory_uri(). '/assets/css/vendor.css' );
	wp_enqueue_style( 'main', get_template_directory_uri(). '/assets/css/main.css' );
	wp_enqueue_style( 'philosophy-style', get_stylesheet_uri());


	//JavaScript
	wp_enqueue_script( 'jquery' );	
	wp_enqueue_script( 'philosophy-modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', array(), '3.3.1', true );	
	wp_enqueue_script( 'philosophy-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array(), '3.3.1', true );	
	wp_enqueue_script( 'philosophy-pace', get_template_directory_uri() . '/assets/js/pace.min.js', array(), '1.0.0', true );	
	if (is_page_template( 'page-contact.php' )) {
		wp_enqueue_script( 'philosophy-map', 'https://maps.googleapis.com/maps/api/js', array(), '1.0.0', true );
	}

	wp_enqueue_script( 'philosophy-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.0.0', true );
	wp_enqueue_script( 'philosophy-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'philosophy_scripts' );