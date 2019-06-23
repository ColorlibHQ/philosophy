<?php 
// Block direct access
if( !defined( 'ABSPATH' ) ){
	exit( 'Direct script access denied.' );
}
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */

// Sidebar
if( is_active_sidebar( 'philosophy-page-sidebar' ) ){
	
	echo '<aside class="page--sidebar col-md-3">';
		dynamic_sidebar( 'philosophy-page-sidebar' );
	echo '</aside>';
}
 

?>