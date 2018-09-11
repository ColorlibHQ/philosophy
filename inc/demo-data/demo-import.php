<?php 
if( !defined( 'WPINC' ) ){
    die;
}
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */

// demo import file

function philosophy_import_files() {
	
	$demoImg = '<img src="'.PHILOSOPHY_DIR_URI.'inc/demo-data/screen-image.png" alt="'.esc_attr__( 'Demo Preview Imgae', 'philosophy' ).'" />';
	
  return array(
    array(
      'import_file_name'             => PHILOSOPHY_DIR_PATH.'inc/demo-data/Philosophy Demo',
      'local_import_file'            => PHILOSOPHY_DIR_PATH.'inc/demo-data/philosophy-demo.xml',
      'local_import_widget_file'     => PHILOSOPHY_DIR_PATH.'inc/demo-data/philosophy-widgets-demo.json',
      'import_customizer_file_url'   => PHILOSOPHY_DIR_URI.'inc/demo-data/philosophy-customizer.dat',
      'import_notice' => $demoImg,
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'philosophy_import_files' );
	
// demo import setup
function philosophy_after_import_setup() {
	// Assign menus to their locations.
	$main_menu   = get_term_by( 'name', 'Menu', 'nav_menu' );
	$social_menu = get_term_by( 'name', 'Social', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'primary-menu' => $main_menu->term_id,
			'social-menu'  => $social_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).

	update_option( 'show_on_front', 'page' );
}
add_action( 'pt-ocdi/after_import', 'philosophy_after_import_setup' );

//disable the branding notice after successful demo import
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

//change the location, title and other parameters of the plugin page
function philosophy_import_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'One Click Demo Import' , 'philosophy' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'philosophy' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'philosophy-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'philosophy_import_plugin_page_setup' );

// Enqueue scripts
function philosophy_demo_import_custom_scripts(){
	
	
	if( isset( $_GET['page'] ) && $_GET['page'] == 'philosophy-demo-import' ){
		// style
		wp_enqueue_style( 'philosophy-demo-import', PHILOSOPHY_DIR_URI.'inc/demo-data/css/demo-import.css', array(), '1.0', false );
	}
	
	
}
add_action( 'admin_enqueue_scripts', 'philosophy_demo_import_custom_scripts' );



?>