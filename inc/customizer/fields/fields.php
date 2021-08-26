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
Epsilon_Customizer::add_field(
    'philosophy_preloader_toggle',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Preloader On/Off', 'philosophy' ),
        'description' => esc_html__( 'Toggle to display preloader.', 'philosophy' ),
        'section'     => 'philosophy_general_section',
        'default'     => true,
    )
);
// Preloader background color field
Epsilon_Customizer::add_field(
    'philosophy_preloader_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Preloader Background Color', 'philosophy' ),
        'description' => esc_html__( 'Select the preloader background color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_general_section',
        'default'     => '#050505',
    )
);
// Preloader color field
Epsilon_Customizer::add_field(
    'philosophy_preloader_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Preloader Color', 'philosophy' ),
        'description' => esc_html__( 'Select the preloader color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_general_section',
        'default'     => '#ffffff',
    )
);
// Back to top toggle field
Epsilon_Customizer::add_field(
    'philosophy_backtotop_btn',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Back to top', 'philosophy' ),
        'description' => esc_html__( 'Toggle the back to top button show.', 'philosophy' ),
        'section'     => 'philosophy_general_section',
        'default'     => true,
    )
);
// Back to top button background color field
Epsilon_Customizer::add_field(
    'philosophy_backtotop_btn_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Back to top button background color.', 'philosophy' ),
        'description' => esc_html__( 'Select the back to top button background color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_general_section',
        'default'     => '#000000',
    )
);

// Back top button hover background color field
Epsilon_Customizer::add_field(
    'philosophy_backtotop_btn_hover_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Back to top button hover background color.', 'philosophy' ),
        'description' => esc_html__( 'Select the back to top button hover background color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_general_section',
        'default'     => '#0054a5',
    )
);
// Google map api key field
$url = 'https://developers.google.com/maps/documentation/geocoding/get-api-key';

Epsilon_Customizer::add_field(
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
Epsilon_Customizer::add_field(
    'philosophy_hsearchform_toggle',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Show header search form', 'philosophy' ),
        'description' => esc_html__( 'Toggle to show header search form.', 'philosophy' ),
        'section'     => 'philosophy_header_section',
        'default'     => true,
    )
);
// Header social icon toggle field
Epsilon_Customizer::add_field(
    'philosophy_headersocial_toggle',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Show header social icon', 'philosophy' ),
        'description' => esc_html__( 'Toggle to show header social icon.', 'philosophy' ),
        'section'     => 'philosophy_header_section',
        'default'     => true,
    )
);
// Header background color field
Epsilon_Customizer::add_field(
    'philosophy_header_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header Background Color', 'philosophy' ),
        'description' => esc_html__( 'Select the header background color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#151515',
    )
);
// Header top color field
Epsilon_Customizer::add_field(
    'philosophy_header_top_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header Top Color', 'philosophy' ),
        'description' => esc_html__( 'Select the header top color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#fff',
    )
);
// Header nav menu color field
Epsilon_Customizer::add_field(
    'philosophy_header_menu_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header menu color', 'philosophy' ),
        'description' => esc_html__( 'Select the header nav menu color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#fff',
    )
);

// Header nav menu hover color field
Epsilon_Customizer::add_field(
    'philosophy_header_menu_hover_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header menu hover color', 'philosophy' ),
        'description' => esc_html__( 'Select the header nav menu hover color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#b5b3b3',
    )
);
// Header menu dropdown background color field
Epsilon_Customizer::add_field(
    'philosophy_header_menu_dropbg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header menu dropdown background color', 'philosophy' ),
        'description' => esc_html__( 'Select the header menu dropdown background color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#050505',
    )
);
// Header dropdown menu color field
Epsilon_Customizer::add_field(
    'philosophy_header_drop_menu_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Dropdown menu color', 'philosophy' ),
        'description' => esc_html__( 'Select the header dropdown menu color.', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_header_section',
        'default'     => '#b5b3b3',
    )
);
// Header dropdown menu hover color field
Epsilon_Customizer::add_field(
    'philosophy_header_drop_menu_hover_color',
    array(
        'type'        => 'epsilon-color-picker',
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
Epsilon_Customizer::add_field(
    'philosophy_hfblog_toggle',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Display features blog section', 'philosophy' ),
        'description' => esc_html__( 'Toggle to display front page feature blog section.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => true,
    )
);
// Home features blog category select field
Epsilon_Customizer::add_field(
    'philosophy_featured_cat',
    array(
        'type'        => 'select',
        'label'       => esc_html__( 'Display features blog section', 'philosophy' ),
        'description' => esc_html__( 'Toggle to display front page feature blog section.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => 'uncategorized',
        'choices'     => philosophy_get_post_cat() // This function create in support-functions.php

    )
);
// Post excerpt length field
Epsilon_Customizer::add_field(
    'philosophy_excerpt_length',
    array(
        'type'        => 'text',
        'label'       => esc_html__( 'Set post excerpt length', 'philosophy' ),
        'description' => esc_html__( 'Set post excerpt length.', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'     => '30',
    )
);
// Blog sidebar layout field
Epsilon_Customizer::add_field(
    'philosophy_blog_layout',
    array(
        'type'     => 'epsilon-layouts',
        'label'    => esc_html__( 'Blog Layout', 'philosophy' ),
        'section'  => 'philosophy_blog_section',
        'description' => esc_html__( 'Select the option to set blog page layout.', 'philosophy' ),
        'layouts'  => array(
            '1' => get_template_directory_uri() . '/inc/libraries/epsilon-framework/assets/img/one-column.png',
            '2' => get_template_directory_uri() . '/inc/libraries/epsilon-framework/assets/img/epsilon-section-titleright.jpg',
            '3' => get_template_directory_uri() . '/inc/libraries/epsilon-framework/assets/img/epsilon-section-titleleft.jpg',
        ),
        'default'  => array(
            'columnsCount' => 1,
            'columns'      => array(
                1 => array(
                    'index' => 1,
                ),
                2 => array(
                    'index' => 2,
                ),
                3 => array(
                    'index' => 3,
                ),
            ),
        ),
        'min_span' => 4,
        'fixed'    => true
    )
);
// Archive page header content field
Epsilon_Customizer::add_field(
    'philosophy_archive_header_content',
    array(
        'type'        => 'epsilon-text-editor',
        'label'       => esc_html__( 'Archive page header content', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => 'Write something......',
    )
);
// Search page header content field
Epsilon_Customizer::add_field(
    'philosophy_search_header_content',
    array(
        'type'        => 'epsilon-text-editor',
        'label'       => esc_html__( 'Search page header content', 'philosophy' ),
        'section'     => 'philosophy_blog_section',
        'default'     => 'Write something......',
    )
);
/***********************************
 * About Section Fields
 ***********************************/

// About page top title field
Epsilon_Customizer::add_field(
    'philosophy_about_top_title',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'About page top title', 'philosophy' ),
        'section'           => 'philosophy_about_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Learn More About Us.', 'philosophy' )
    )
);
// About info block content field
Epsilon_Customizer::add_field(
    'philosophy_about_infoblock',
    array(
        'type'         => 'epsilon-repeater',
        'section'      => 'philosophy_about_section',
        'label'        => esc_html__( 'About info block content', 'philosophy' ),
        'button_label' => esc_html__( 'Add new block', 'philosophy' ),
        'row_label'    => array(
            'type'  => 'field',
            'field' => 'info_title',
            ),
        'fields'       => array(
            'info_title'       => array(
                'label'             => esc_html__( 'Title', 'philosophy' ),
                'type'              => 'text',
                'default'           => esc_html__( 'Who We Are.', 'philosophy' ),
            ),
            'info_desc'        => array(
                'label'             => esc_html__( 'Descriptions', 'philosophy' ),
                'type'              => 'epsilon-text-editor',
                'default'           => 'Write something....',
            ),
        ),
    )
);

/***********************************
 * Contact Section Fields
 ***********************************/

// Contact page top title field
Epsilon_Customizer::add_field(
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
$wp_customize->add_setting( 'philosophy_map_marker' , array(
    'default'               =>  esc_url( PHILOSOPHY_DIR_URI . '/img/icon-location@2x.png' ),
    'transport'             => 'refresh', // refresh or postMessage
    'capability'            => 'edit_theme_options',
    'sanitize_callback'     => 'philosophy_theme_customizer::philosophy_sanitize_image'
) );

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
Epsilon_Customizer::add_field(
    'philosophy_contact_latitude',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'Latitude', 'philosophy' ),
        'section'           => 'philosophy_contact_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '37.422424'
    )
);
// Map longitude  field
Epsilon_Customizer::add_field(
    'philosophy_contact_longitude',
    array(
        'type'              => 'text',
        'label'             => esc_html__( 'Longitude', 'philosophy' ),
        'section'           => 'philosophy_contact_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '-122.085661'
    )
);

//  Contact info block field
Epsilon_Customizer::add_field(
    'philosophy_contact_infoblock',
    array(
        'type'         => 'epsilon-repeater',
        'section'      => 'philosophy_contact_section',
        'label'        => esc_html__( 'Contact info block content', 'philosophy' ),
        'button_label' => esc_html__( 'Add new block', 'philosophy' ),
        'row_label'    => array(
            'type'  => 'field',
            'field' => 'info_title',
            ),
        'fields'       => array(
            'info_title'       => array(
                'label'             => esc_html__( 'Title', 'philosophy' ),
                'type'              => 'text',
                'default'           => esc_html__( 'Where to Find Us', 'philosophy' ),
            ),
            'contact_info'        => array(
                'label'             => esc_html__( 'Information', 'philosophy' ),
                'type'              => 'epsilon-text-editor',
                'default'           => 'Write something....',
            ),
        ),
    )
);
// contact form title field
Epsilon_Customizer::add_field(
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

Epsilon_Customizer::add_field(
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
Epsilon_Customizer::add_field(
    'philosophy_contact_custom_formshortcode',
    array(
        'type'        => 'epsilon-text-editor',
        'label'       => esc_html__( 'Set custom contact form shortcode', 'philosophy' ),
        'section'     => 'philosophy_contact_section',
        'default'     => '',
    )
);

/***********************************
 * 404 Page Section Fields
 ***********************************/

// 404 text #1 field
Epsilon_Customizer::add_field(
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
Epsilon_Customizer::add_field(
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
Epsilon_Customizer::add_field(
    'philosophy_fof_textone_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( '404 Text #1 Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_fof_section',
        'default'     => '#000000',
    )
);
// 404 text #2 color field
Epsilon_Customizer::add_field(
    'philosophy_fof_texttwo_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( '404 Text #2 Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_fof_section',
        'default'     => '#656565',
    )
);
// 404 background color field
Epsilon_Customizer::add_field(
    'philosophy_fof_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
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
Epsilon_Customizer::add_field(
    'philosophy_footer_widget_toggle',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Footer widget show/hide', 'philosophy' ),
        'description' => esc_html__( 'Toggle to display footer widgets.', 'philosophy' ),
        'section'     => 'philosophy_footer_section',
        'default'     => true,
    )
);
// Footer copyright text field
Epsilon_Customizer::add_field(
    'philosophy_footer_copyright_text',
    array(
        'type'        => 'epsilon-text-editor',
        'label'       => esc_html__( 'Footer copyright text', 'philosophy' ),
        'section'     => 'philosophy_footer_section',
        'default'     => sprintf( __( 'Copyright &copy; %s All rights reserved. | This template is made with %s by <a href="%s" target="_blank">Colorlib</a>', 'philosophy' ), date('Y') ,'<i class="fa fa-heart-o" aria-hidden="true"></i>', 'https://colorlib.com' ),
    )
);
// Footer widget background color field
Epsilon_Customizer::add_field(
    'philosophy_footer_widget_bdcolor',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Background Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#19191b',
    )
);
// Footer widget text color field
Epsilon_Customizer::add_field(
    'philosophy_footer_widget_textcolor',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Text Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#FFFFFF',
    )
);
// Footer widget title color field
Epsilon_Customizer::add_field(
    'philosophy_footer_widget_titlecolor',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Widget Title Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#FFFFFF',
    )
);
// Footer widget anchor color field
Epsilon_Customizer::add_field(
    'philosophy_footer_widget_anchorcolor',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Anchor Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#888888',
    )
);
// Footer widget anchor hover color field
Epsilon_Customizer::add_field(
    'philosophy_footer_widget_anchorhovcolor',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Anchor Hover Color', 'philosophy' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'philosophy_footer_section',
        'default'     => '#888888',
    )
);

?>