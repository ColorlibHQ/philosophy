<?php 
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 * Customizer panels and sections
 *
 */

/***********************************
 * Register customizer panels
 ***********************************/

$panels = array(
    /**
     * Theme Options Panel
     */
    array(
        'id'   => 'philosophy_theme_options_panel',
        'args' => array(
            'priority'       => 0,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => esc_html__( 'Theme Options', 'philosophy' ),
        ),
    )
);


/***********************************
 * Register customizer sections
 ***********************************/


$sections = array(
    /**
     * General Section
     */
    array(
        'id'   => 'philosophy_general_section',
        'args' => array(
            'title'    => esc_html__( 'General', 'philosophy' ),
            'panel'    => 'philosophy_theme_options_panel',
            'priority' => 1,
        ),
    ),
    /**
     * Header Section
     */
    array(
        'id'   => 'philosophy_header_section',
        'args' => array(
            'title'    => esc_html__( 'Header', 'philosophy' ),
            'panel'    => 'philosophy_theme_options_panel',
            'priority' => 2,
        ),
    ),
    /**
     * Blog Section
     */
    array(
        'id'   => 'philosophy_blog_section',
        'args' => array(
            'title'    => esc_html__( 'Blog', 'philosophy' ),
            'panel'    => 'philosophy_theme_options_panel',
            'priority' => 3,
        ),
    ),

    /**
     * About Page Section
     */
    array(
        'id'   => 'philosophy_about_section',
        'args' => array(
            'title'    => esc_html__( 'About Page', 'philosophy' ),
            'panel'    => 'philosophy_theme_options_panel',
            'priority' => 4,
        ),
    ),
    /**
     * Contact Page Section
     */
    array(
        'id'   => 'philosophy_contact_section',
        'args' => array(
            'title'    => esc_html__( 'Contact Page', 'philosophy' ),
            'panel'    => 'philosophy_theme_options_panel',
            'priority' => 5,
        ),
    ),
    /**
     * 404 Page Section
     */
    array(
        'id'   => 'philosophy_fof_section',
        'args' => array(
            'title'    => esc_html__( '404 Page', 'philosophy' ),
            'panel'    => 'philosophy_theme_options_panel',
            'priority' => 6,
        ),
    ),
    /**
     * Footer Section
     */
    array(
        'id'   => 'philosophy_footer_section',
        'args' => array(
            'title'    => esc_html__( 'Footer Page', 'philosophy' ),
            'panel'    => 'philosophy_theme_options_panel',
            'priority' => 7,
        ),
    ),

);


/***********************************
 * Add customizer elements
 ***********************************/
$collection = array(
    'panel'   => $panels,
    'section' => $sections,
);

Epsilon_Customizer::add_multiple( $collection );

?>