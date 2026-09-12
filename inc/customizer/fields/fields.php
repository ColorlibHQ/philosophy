<?php 
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 * Customizer section fields
 *
 */

/***********************************
 * General Section Fields
 ***********************************/

// Preloader toggle field
Philosophy_Customizer::add_field(
    'philosophy_preloader_toggle',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__( 'Preloader On/Off', 'philosophy' ),
        'description' => esc_html__( 'Toggle to display preloader.', 'philosophy' ),
        'section'     => 'philosophy_general_section',
        'default'     => true,
    )
);
// Preloader background color field
Philosophy_Customizer::add_field(
    'philosophy_preloader_bg_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Preloader Background Color', 'philosophy' ),
        'description' => esc_html__( 'Select the preloader background color.', 'philosophy' ),
        'sanitize_callback' => 'philosophy_sanitize_color',
        'section'     => 'philosophy_general_section',
        'default'     => '#050505',
    )
);
// Preloader color field
Philosophy_Customizer::add_field(
    'philosophy_preloader_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Preloader Color', 'philosophy' ),
        'description' => esc_html__( 'Select the preloader color.', 'philosophy' ),
        'sanitize_callback' => 'philosophy_sanitize_color',
        'section'     => 'philosophy_general_section',
        'default'     => '#ffffff',
    )
);
// Back to top toggle field
Philosophy_Customizer::add_field(
    'philosophy_backtotop_btn',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__( 'Back to top', 'philosophy' ),
        'description' => esc_html__( 'Toggle the back to top button show.', 'philosophy' ),
        'section'     => 'philosophy_general_section',
        'default'     => true,
    )
);
// Back to top button background color field
Philosophy_Customizer::add_field(
    'philosophy_backtotop_btn_bg_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Back to top button background color.', 'philosophy' ),
        'description' => esc_html__( 'Select the back to top button background color.', 'philosophy' ),
        'sanitize_callback' => 'philosophy_sanitize_color',
        'section'     => 'philosophy_general_section',
        'default'     => '#000000',
    )
);

// Back top button hover background color field
Philosophy_Customizer::add_field(
    'philosophy_backtotop_btn_hover_bg_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Back to top button hover background color.', 'philosophy' ),
        'description' => esc_html__( 'Select the back to top button hover background color.', 'philosophy' ),
        'sanitize_callback' => 'philosophy_sanitize_color',
        'section'     => 'philosophy_general_section',
        'default'     => '#0054a5',
    )
);
// Google map api key field
$url = 'https://developers.google.com/maps/documentation/geocoding/get-api-key';

Philosophy_Customizer::add_field(
    'philosophy_gmap_api_key',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'Google map api key', 'philosophy' ),
        'description'       => sprintf( __( 'Set google map api key. To get api key %s click here %s.', 'philosophy' ), '<a target="_blank" href="'.esc_url( $url  ).'">', '</a>' ),
        'section'           => 'philosophy_general_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        
    )
);
/***********************************
 * Header Section Fields
 ***********************************/

// Header search form toggle field
Philosophy_Customizer::add_field(
    'philosophy_hsearchform_toggle',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__( 'Show header search form', 'philosophy' ),
        'description' => esc_html__( 'Toggle to show header search form.', 'philosophy' ),
        'section'     => 'philosophy_header_section',
        'default'     => true,
    )
);
// Header social icon toggle field
Philosophy_Customizer::add_field(
    'philosophy_headersocial_toggle',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__( 'Show header social icon', 'philosophy' ),
        'description' => esc_html__( 'Toggle to show header social icon.', 'philosophy' ),
        'section'     => 'philosophy_header_section',
        'default'     => true,
    )
);
// Header background color field
Philosophy_Customizer::add_field(
    'philosophy_header_bg_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Header Background Color', 'philosophy' ),
        'description' => esc_html__( 'Select the header background color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#151515',
    )
);
// Header top color field
Philosophy_Customizer::add_field(
    'philosophy_header_top_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Header Top Color', 'philosophy' ),
        'description' => esc_html__( 'Select the header top color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#fff',
    )
);
// Header nav menu color field
Philosophy_Customizer::add_field(
    'philosophy_header_menu_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Header menu color', 'philosophy' ),
        'description' => esc_html__( 'Select the header nav menu color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#fff',
    )
);

// Header nav menu hover color field
Philosophy_Customizer::add_field(
    'philosophy_header_menu_hover_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Header menu hover color', 'philosophy' ),
        'description' => esc_html__( 'Select the header nav menu hover color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#b5b3b3',
    )
);
// Header menu dropdown background color field
Philosophy_Customizer::add_field(
    'philosophy_header_menu_dropbg_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Header menu dropdown background color', 'philosophy' ),
        'description' => esc_html__( 'Select the header menu dropdown background color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#050505',
    )
);
// Header dropdown menu color field
Philosophy_Customizer::add_field(
    'philosophy_header_drop_menu_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Dropdown menu color', 'philosophy' ),
        'description' => esc_html__( 'Select the header dropdown menu color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#b5b3b3',
    )
);
// Header dropdown menu hover color field
Philosophy_Customizer::add_field(
    'philosophy_header_drop_menu_hover_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Dropdown menu hover color', 'philosophy' ),
        'description' => esc_html__( 'Select the header dropdown menu hover color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#ffffff',
    )
);

/***********************************
 * Blog Section Fields
 ***********************************/

// Home features blog section toggle field
Philosophy_Customizer::add_field(
    'philosophy_hfblog_toggle',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__( 'Display features blog section', 'philosophy' ),
        'description' => esc_html__( 'Toggle to display front page feature blog section.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => true,
    )
);
// Home features blog category select field
Philosophy_Customizer::add_field(
    'philosophy_featured_cat',
    array(
        'type'        => 'select',
        'label'       => esc_html__( 'Featured post category', 'philosophy' ),
        'description' => esc_html__( 'Posts from this category fill the featured area on the blog home page.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => 'uncategorized',
        'choices'     => philosophy_get_post_cat() // This function create in support-functions.php

    )
);
// Post excerpt length field
Philosophy_Customizer::add_field(
    'philosophy_excerpt_length',
    array(
        'type'        => 'number',
        'label'       => esc_html__( 'Post excerpt length', 'philosophy' ),
        'description' => esc_html__( 'Number of words shown in each excerpt.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'sanitize_callback' => 'philosophy_sanitize_number',
        'input_attrs' => array(
            'min'  => 5,
            'max'  => 200,
            'step' => 1,
        ),
        'default'     => 30,
    )
);
// Blog sidebar layout field
Philosophy_Customizer::add_field(
    'philosophy_blog_layout',
    array(
        'type'     => 'radio',
        'label'    => esc_html__( 'Blog Layout', 'philosophy' ),
        'section'  => 'philosophy_blog_section',
        // Not the default sanitizer for a radio: sites upgrading from 1.1.x
        // hold Epsilon's column-descriptor array here, and a choices check
        // would throw it away.
        'sanitize_callback' => 'philosophy_sanitize_layout',
        'description' => esc_html__( 'Select the option to set blog page layout.', 'philosophy' ),
        'choices'  => array(
            '1' => esc_html__( 'Full width', 'philosophy' ),
            '2' => esc_html__( 'Right sidebar', 'philosophy' ),
            '3' => esc_html__( 'Left sidebar', 'philosophy' ),
        ),
        'default'  => '1',
    )
);
// Archive page header content field
Philosophy_Customizer::add_field(
    'philosophy_archive_header_content',
    array(
        'type'        => 'textarea',
        'label'       => esc_html__( 'Archive page header content', 'philosophy' ),
        'description' => esc_html__( 'Optional text shown under the title on category, tag and date archives.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => '',
    )
);
// Search page header content field
Philosophy_Customizer::add_field(
    'philosophy_search_header_content',
    array(
        'type'        => 'textarea',
        'label'       => esc_html__( 'Search page header content', 'philosophy' ),
        'description' => esc_html__( 'Optional text shown under the title on the search results page.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => '',
    )
);
/***********************************
 * About Section Fields
 ***********************************/

// About page top title field
Philosophy_Customizer::add_field(
    'philosophy_about_top_title',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'About page top title', 'philosophy' ),
        'section'           => 'philosophy_about_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Learn More About Us.', 'philosophy' )
    )
);

/***********************************
 * Contact Section Fields
 ***********************************/

// Contact page top title field
Philosophy_Customizer::add_field(
    'philosophy_contact_top_title',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'Contact page top title', 'philosophy' ),
        'section'           => 'philosophy_contact_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Feel Free To Contact Us.', 'philosophy' )
    )
);

// Google map marker
$wp_customize->add_setting(
    'philosophy_map_marker',
    array(
        'default'           => PHILOSOPHY_DIR_URI . 'img/icon-location@2x.png',
        'transport'         => 'refresh',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => array( 'philosophy_theme_customizer', 'philosophy_sanitize_image' ),
    )
);

$wp_customize->add_control(
   new WP_Customize_Image_Control( $wp_customize, 'google_map_marker_img',
       array(
           'label'      => esc_html__( 'Upload map marker image', 'philosophy' ),
           'section'    => 'philosophy_contact_section',
           'settings'   => 'philosophy_map_marker'
       )
   )
);

// Map latitude  field
Philosophy_Customizer::add_field(
    'philosophy_contact_latitude',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'Latitude', 'philosophy' ),
        'section'           => 'philosophy_contact_section',
        'sanitize_callback' => 'philosophy_sanitize_coordinate',
        'default'           => '37.422424'
    )
);
// Map longitude  field
Philosophy_Customizer::add_field(
    'philosophy_contact_longitude',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'Longitude', 'philosophy' ),
        'section'           => 'philosophy_contact_section',
        'sanitize_callback' => 'philosophy_sanitize_coordinate',
        'default'           => '-122.085661'
    )
);

// contact form title field
Philosophy_Customizer::add_field(
    'philosophy_contact_formtitle',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'Form Title', 'philosophy' ),
        'section'           => 'philosophy_contact_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Say Hello.'
    )
);
// contact Form 7 shortcode field

$options = philosophy_contact_form7_shortcode(); // This function create in support-functions.php

Philosophy_Customizer::add_field(
    'philosophy_contact_formshortcode',
    array(
        'type'              => 'select',
        'label'             => esc_html__( 'Contact Form', 'philosophy' ),
        'section'           => 'philosophy_contact_section',
        'description'       => $options[1],
        'default'           => 'cs',
        'choices'           => $options[0] 
    )
);
// Custom contact form shortcode field
Philosophy_Customizer::add_field(
    'philosophy_contact_custom_formshortcode',
    array(
        'type'        => 'textarea',
        'label'       => esc_html__( 'Set custom contact form shortcode', 'philosophy' ),
        'section'     => 'philosophy_contact_section',
        'default'     => '',
    )
);

/***********************************
 * 404 Page Section Fields
 ***********************************/

// 404 text #1 field
Philosophy_Customizer::add_field(
    'philosophy_fof_titleone',
    array(
        'type'              => 'text',
        'label'             => esc_html__( '404 Text #1', 'philosophy' ),
        'section'           => 'philosophy_fof_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Ooops 404 Error !', 'philosophy' )
    )
);
// 404 text #2 field
Philosophy_Customizer::add_field(
    'philosophy_fof_titletwo',
    array(
        'type'              => 'text',
        'label'             => esc_html__( '404 Text #2', 'philosophy' ),
        'section'           => 'philosophy_fof_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => wp_kses_post( __( 'Either something went wrong or the page dosen&rsquo;t exist anymore.', 'philosophy' ) )
    )
);
// 404 text #1 color field
Philosophy_Customizer::add_field(
    'philosophy_fof_textone_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( '404 Text #1 Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_fof_section',
        'default'     => '#000000',
    )
);
// 404 text #2 color field
Philosophy_Customizer::add_field(
    'philosophy_fof_texttwo_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( '404 Text #2 Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_fof_section',
        'default'     => '#656565',
    )
);
// 404 background color field
Philosophy_Customizer::add_field(
    'philosophy_fof_bg_color',
    array(
        'type'        => 'color',
        'label'       => esc_html__( '404 Page Background Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_fof_section',
        'default'     => '#fff',
    )
);

/***********************************
 * Footer Section Fields
 ***********************************/

// Footer widget toggle field
Philosophy_Customizer::add_field(
    'philosophy_footer_widget_toggle',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__( 'Footer widget show/hide', 'philosophy' ),
        'description' => esc_html__( 'Toggle to display footer widgets.', 'philosophy' ),
        'section'     => 'philosophy_footer_section',
        'default'     => true,
    )
);
// Footer copyright text field
Philosophy_Customizer::add_field(
    'philosophy_footer_copyright_text',
    array(
        'type'        => 'textarea',
        'label'       => esc_html__( 'Footer copyright text', 'philosophy' ),
        'section'     => 'philosophy_footer_section',
        'default'     => philosophy_default_copyright(),
    )
);
// Footer widget background color field
Philosophy_Customizer::add_field(
    'philosophy_footer_widget_bdcolor',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Footer Background Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#19191b',
    )
);
// Footer widget text color field
Philosophy_Customizer::add_field(
    'philosophy_footer_widget_textcolor',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Footer Text Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#FFFFFF',
    )
);
// Footer widget title color field
Philosophy_Customizer::add_field(
    'philosophy_footer_widget_titlecolor',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Footer Widget Title Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#FFFFFF',
    )
);
// Footer widget anchor color field
Philosophy_Customizer::add_field(
    'philosophy_footer_widget_anchorcolor',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Footer Anchor Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#888888',
    )
);
// Footer widget anchor hover color field
Philosophy_Customizer::add_field(
    'philosophy_footer_widget_anchorhovcolor',
    array(
        'type'        => 'color',
        'label'       => esc_html__( 'Footer Anchor Hover Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#888888',
    )
);

?>