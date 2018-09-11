<?php 
// Block direct access
if( !defined( 'ABSPATH' ) ){
	exit( 'Direct script access denied.' );
}
/**
 * @Packge 	   : Philosophy
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */

?>

<div class="s-footer__main">
    <div class="row">
		<?php 
		// Footer widget 1
		if( is_active_sidebar( 'footer-1' ) ){
			echo '<div class="col-two md-four mob-full">';
				dynamic_sidebar( 'footer-1' );
			echo '</div>';
		}

		// Footer widget 2
		if( is_active_sidebar( 'footer-2' ) ){
			echo '<div class="col-two md-four mob-full">';
				dynamic_sidebar( 'footer-2' );
			echo '</div>';
		}

		// Footer widget 3
		if( is_active_sidebar( 'footer-3' ) ){
			echo '<div class="col-two md-four mob-full">';
				dynamic_sidebar( 'footer-3' );
			echo '</div>';
		}
		
		// Footer widget 4
		if( is_active_sidebar( 'footer-4' ) ){
			echo '<div class="col-five md-full end">';
				dynamic_sidebar( 'footer-4' );
			echo '</div>';
		}
		?>

    </div>
</div>