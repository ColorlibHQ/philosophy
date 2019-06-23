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
if( is_active_sidebar( 'philosophy-post-sidebar' ) ){
	
	echo '<div class="col-three"><div class="philosophy-blog-sidebar">';
		dynamic_sidebar( 'philosophy-post-sidebar' );
	echo '</div></div>';
}
 

?>