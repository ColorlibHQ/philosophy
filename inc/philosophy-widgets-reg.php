<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit( 'Direct script access denied.' );
}

/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
 
function philosophy_widgets_init() {
    // sidebar widgets 
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'philosophy' ),
        'id'            => 'philosophy-post-sidebar',
        'before_widget' => '<div id="%1$s" class="sidebar-widget widget blog-post-archives mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>',
    ) );
    
    // Footer sidebar #1 
    register_sidebar( array(
        'name'          => esc_html__( 'Footer sidebar #1', 'philosophy' ),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="single-footer-widget widget mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );

    // Footer sidebar #2 
    register_sidebar( array(
        'name'          => esc_html__( 'Footer sidebar #2', 'philosophy' ),
        'id'            => 'footer-2',
        'before_widget' => '<div id="%1$s" class="single-footer-widget widget mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );

    // Footer sidebar #3 
    register_sidebar( array(
        'name'          => esc_html__( 'Footer sidebar #3', 'philosophy' ),
        'id'            => 'footer-3',
        'before_widget' => '<div id="%1$s" class="single-footer-widget widget mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );
    
    // Footer sidebar #4 
    register_sidebar( array(
        'name'          => esc_html__( 'Footer sidebar #4', 'philosophy' ),
        'id'            => 'footer-4',
        'before_widget' => '<div id="%1$s" class="single-footer-widget widget mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
    // Footer sidebar #5 
    register_sidebar( array(
        'name'          => esc_html__( 'Footer sidebar #5', 'philosophy' ),
        'id'            => 'footer-5',
        'before_widget' => '<div id="%1$s" class="single-footer-widget widget mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
    // Footer sidebar #6
    register_sidebar( array(
        'name'          => esc_html__( 'Footer sidebar #6', 'philosophy' ),
        'id'            => 'footer-6',
        'before_widget' => '<div id="%1$s" class="single-footer-widget widget mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
    // Footer sidebar #7
    register_sidebar( array(
        'name'          => esc_html__( 'Footer sidebar #7', 'philosophy' ),
        'id'            => 'footer-7',
        'before_widget' => '<div id="%1$s" class="single-footer-widget widget mb-100 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    
    
}
add_action( 'widgets_init', 'philosophy_widgets_init' );
