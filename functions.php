<?php 
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	/**
	 *
	 * Define constant
	 *
	 */
	
	 
	// Base URI
	if( !defined( 'PHILOSOPHY_DIR_URI' ) )
		define( 'PHILOSOPHY_DIR_URI', get_template_directory_uri().'/' );
	
	// assets URI
	if( !defined( 'PHILOSOPHY_DIR_ASSETS_URI' ) )
		define( 'PHILOSOPHY_DIR_ASSETS_URI', PHILOSOPHY_DIR_URI.'assets/' );
	
	// Css File URI
	if( !defined( 'PHILOSOPHY_DIR_CSS_URI' ) )
		define( 'PHILOSOPHY_DIR_CSS_URI', PHILOSOPHY_DIR_ASSETS_URI .'css/' );
	
	// Js File URI
	if( !defined( 'PHILOSOPHY_DIR_JS_URI' ) )
		define( 'PHILOSOPHY_DIR_JS_URI', PHILOSOPHY_DIR_ASSETS_URI .'js/' );
	
	// Icon Images
	if( !defined('PHILOSOPHY_DIR_ICON_IMG_URI') )
		define( 'PHILOSOPHY_DIR_ICON_IMG_URI', PHILOSOPHY_DIR_URI.'img/core-img/' );
	
	// Base Directory
	if( !defined( 'PHILOSOPHY_DIR_PATH' ) )
		define( 'PHILOSOPHY_DIR_PATH', get_parent_theme_file_path().'/' );
	
	//Inc Folder Directory
	if( !defined( 'PHILOSOPHY_DIR_PATH_INC' ) )
		define( 'PHILOSOPHY_DIR_PATH_INC', PHILOSOPHY_DIR_PATH.'inc/' );
	
	//Colorlib framework Folder Directory
	if( !defined( 'PHILOSOPHY_DIR_PATH_FRAM' ) )
		define( 'PHILOSOPHY_DIR_PATH_FRAM', PHILOSOPHY_DIR_PATH_INC.'philosophy-framework/' );
	
	//Classes Folder Directory
	if( !defined( 'PHILOSOPHY_DIR_PATH_CLASSES' ) )
		define( 'PHILOSOPHY_DIR_PATH_CLASSES', PHILOSOPHY_DIR_PATH_INC.'classes/' );
	
	//Hooks Folder Directory
	if( !defined( 'PHILOSOPHY_DIR_PATH_HOOKS' ) )
		define( 'PHILOSOPHY_DIR_PATH_HOOKS', PHILOSOPHY_DIR_PATH_INC.'hooks/' );
	
	//Widgets Folder Directory
	if( !defined( 'PHILOSOPHY_DIR_PATH_WIDGET' ) )
		define( 'PHILOSOPHY_DIR_PATH_WIDGET', PHILOSOPHY_DIR_PATH_INC.'widgets/' );
		
	//Elementor Widgets Folder Directory
	if( !defined( 'PHILOSOPHY_DIR_PATH_ELEMENTOR_WIDGETS' ) )
		define( 'PHILOSOPHY_DIR_PATH_ELEMENTOR_WIDGETS', PHILOSOPHY_DIR_PATH_INC.'elementor-widgets/widgets/' );
	

<<<<<<< HEAD
		
=======

>>>>>>> 5a42a4e760d4c9695deb1c2d83070bd5fb910a24
	/**
	 * Include File
	 *
	 */
	
	// Breadcrumbs file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'philosophy-breadcrumbs.php' );
	// Sidebar register file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'philosophy-widgets-reg.php' );
	// Post widget file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'popular-post-widget.php' );
	// News letter widget file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'philosophy-newsletter-widget.php' );
	// Nav walker file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'wp_bootstrap_navwalker.php' );
	// Theme function file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'philosophy-functions.php' );
	// Inline css file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'philosophy-commoncss.php' );
	// Theme support function file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'support-functions.php' );
	// Html helper file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'wp-html-helper.php' );
	// Pagination file include
	require_once( PHILOSOPHY_DIR_PATH_INC . 'wp_bootstrap_pagination.php' );
	//
	require_once( PHILOSOPHY_DIR_PATH_CLASSES . 'Class-Enqueue.php' );
	require_once( PHILOSOPHY_DIR_PATH_CLASSES . 'Class-Config.php' );
	require_once( PHILOSOPHY_DIR_PATH_HOOKS . 'hooks.php' );
	require_once( PHILOSOPHY_DIR_PATH_HOOKS . 'hooks-functions.php' );
	// Epsilon Framework file Include
	require_once( PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-framework/class-epsilon-framework.php' );
	require_once( PHILOSOPHY_DIR_PATH_FRAM . 'customizer/customizer.php' );

	// Class autoloader
	require_once( PHILOSOPHY_DIR_PATH_INC . 'class-philosophy-autoloader.php' );
	// Class philosophy dashboard
	 require_once( PHILOSOPHY_DIR_PATH_INC . 'class-philosophy-dashboard.php' );
	 
	/**
	 * Instantiate Philosophy object
	 *
	 * Inside this object:
	 * Enqueue scripts, Google font, Theme support features, Philosophy Dashboard .
	 *
	 */
	$Philosophy = new Philosophy();



?>