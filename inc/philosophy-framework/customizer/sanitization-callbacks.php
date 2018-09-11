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
 
/**
 * Customizer: Sanitization Callbacks
 *
 */

/**.
 * Checkbox sanitization callback.
 * 
 */
function philosophy_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * CSS sanitization callback.
 *
 */
function philosophy_sanitize_css( $css ) {
    return wp_strip_all_tags( $css );
}

/**
 * Drop-down Pages sanitization callback.
 *
 */
function philosophy_sanitize_dropdown_pages( $page_id, $setting ) {
    // Ensure $input is an absolute integer.
    $page_id = absint( $page_id );
    
    // If $page_id is an ID of a published page, return it; otherwise, return the default.
    return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/**
 * Email sanitization callback.
 *
 */
function philosophy_sanitize_email( $email, $setting ) {
    // Strips out all characters that are not allowable in an email address.
    $email = sanitize_email( $email );
    
    // If $email is a valid email, return it; otherwise, return the default.
    return ( ! is_null( $email ) ? $email : $setting->default );
}

/**
 * HEX Color sanitization callback.
 *
 */
function philosophy_sanitize_hex_color( $hex_color, $setting ) {
    // Sanitize $input as a hex value without the hash prefix.
    $hex_color = sanitize_hex_color( $hex_color );
    
    // If $input is a valid hex value, return it; otherwise, return the default.
    return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * HTML sanitization callback.
 *
 */
function philosophy_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}

/**
 * Image sanitization callback.
 *
 */
function philosophy_sanitize_image( $image, $setting ) {

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

/**
 * No-HTML sanitization callback.
 *
 */
function philosophy_sanitize_nohtml( $nohtml ) {
    return wp_filter_nohtml_kses( $nohtml );
}

/**
 * Number sanitization callback.
 *
 */
function philosophy_sanitize_number_absint( $number, $setting ) {
    // Ensure $number is an absolute integer (whole number, zero or greater).
    $number = absint( $number );
    
    // If the input is an absolute integer, return it; otherwise, return the default
    return ( $number ? $number : $setting->default );
}

/**
 * Number Range sanitization callback.
 *
 */
function philosophy_sanitize_number_range( $number, $setting ) {
    
    // Ensure input is an absolute integer.
    $number = absint( $number );
    
    // Get the input attributes associated with the setting.
    $atts = $setting->manager->get_control( $setting->id )->input_attrs;
    
    // Get minimum number in the range.
    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
    
    // Get maximum number in the range.
    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
    
    // Get step.
    $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
    
    // If the number is within the valid range, return it; otherwise, return the default
    return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 * Select sanitization callback.
 *
 */
function philosophy_sanitize_select( $input, $setting ) {
    
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * URL sanitization callback.
 *
 */
function philosophy_sanitize_url( $url ) {
    return esc_url_raw( $url );
}

/**
 * Value sanitization callback.
 *
 */
function philosophy_sanitize_repeater( $value ) {
        if ( ! is_array( $value ) ) {
            $value = json_decode( urldecode( $value ) );
        }
        $sanitized = ( empty( $value ) || ! is_array( $value ) ) ? array() : $value;
        // Make sure that every row is an array, not an object.
        foreach ( $sanitized as $key => $_value ) {
            if ( empty( $_value ) ) {
                unset( $sanitized[ $key ] );
            } else {
                $sanitized[ $key ] = (array) $_value;
            }
        }
        // Reindex array.
        if ( is_array( $sanitized ) ) {
            $sanitized = array_values( $sanitized );
        }
        return $sanitized;
}