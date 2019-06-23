<?php 
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */

class philosophy_theme_customizer {


    function __construct(){
        add_action( 'customize_register', array( $this, 'philosophy_theme_customizer_options' ) );
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'philosophy_customizer_js' ) );
    }

    // Customize register hook

    public function philosophy_theme_customizer_options( $wp_customize ){

        // Include files
        include( PHILOSOPHY_DIR_PATH_INC. 'customizer/fields/sections.php' );
        include( PHILOSOPHY_DIR_PATH_INC. 'customizer/fields/fields.php' );

        // Change panel to theme option
        $wp_customize->get_section( 'title_tagline' )->panel      = 'philosophy_theme_options_panel';
        // change priorities
        $wp_customize->get_section( 'title_tagline' )->priority     = 0;


    }


    // Customizer js enqueue

    public function philosophy_customizer_js(){

        wp_enqueue_script( 'philosophy-customizer', PHILOSOPHY_DIR_URI.'inc/customizer/js/customizer.js', array('customize-controls'), '1.0', true );


        $about_page     = self::philosophy_get_page_name( 'page-about.php' );
        $contact_page   = self::philosophy_get_page_name( 'page-contact.php' );

        wp_localize_script( 'philosophy-customizer', 'customizerdata', array(

            'site_url'      => site_url('/'),
            'blog_page'     => get_post_type_archive_link( 'post' ),
            'about_page'    => esc_html( !empty( $about_page[0]->post_name ) ? $about_page[0]->post_name : '' ),
            'contact_page'  => esc_html( !empty( $contact_page[0]->post_name ) ? $contact_page[0]->post_name : '' )

        ) );

    }

    // Get page name by page template
    public static function philosophy_get_page_name( $template ){

        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => esc_html( $template )
        ));

        return $pages;
    }

    // Image sanitization callback.

    public static function philosophy_sanitize_image( $image, $setting ) {

        /*
         * Array of valid image file types.
         *
         * The array includes image mime types that are included in wp_get_mime_types()
         */
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        );

        // Return an array with file extension and mime_type.
        $file = wp_check_filetype( $image, $mimes );

        // If $image has a valid mime_type, return it; otherwise, return the default.
        return ( $file['ext'] ? $image : $setting->default );
    }

}
?>