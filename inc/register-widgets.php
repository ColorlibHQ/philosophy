<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function philosophy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'philosophy' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class="widget md-four mob-full sidebar-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer widget', 'philosophy' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add widgets here. we recommend upto 4 widget here', 'philosophy' ),
		'before_widget' => '<div class="col-three md-four mob-full footer-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );


	//register widget
	// register_widget('philosophy_Subscribe');
}
add_action( 'widgets_init', 'philosophy_widgets_init' );