<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */


add_action( 'cmb2_admin_init', 'philosophy_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function philosophy_register_demo_metabox() {
	$prefix = '_philosophy_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_philosophy = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'For Video post only', 'philosophy' ),
		'object_types'  => array( 'post' ),
		'context'    => 'side',
    	'priority'   => 'default',
    	'show_on'      => array( 'key' => 'post_format', 'value' => 'video' ),
	) );

	$cmb_philosophy->add_field( array(
		'name'       => esc_html__( 'Video URL', 'philosophy' ),
		'desc'       => esc_html__( 'Paste here your video url (don\'t forget to select "Video" from post format)', 'philosophy' ),
		'id'         => $prefix . 'video_url',
		'type'       => 'text_url',
	    'show_names'   => true,
	) );

}

