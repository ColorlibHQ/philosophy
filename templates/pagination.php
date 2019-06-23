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
 
    //Pagination
	if ( function_exists('philosophy_pagination') ){
		philosophy_pagination();

	}else{
		$newer 	= '<i class="fa fm fa-long-arrow-left"></i>'.esc_html__( 'Newer Post', 'philosophy' );
		$older 	= esc_html__( 'Older Post', 'philosophy' ).'<i class="fa flm fa-long-arrow-right"></i>';

        echo '<ul class="pager">';
			// Previous
			echo '<li class="previous">';
			if( get_previous_posts_link() ){
				previous_posts_link( $newer );
			}else{
				echo wp_kses_post( '<span>'.$newer.'</span>' );
			}
			echo '</li>';
			// next
			echo '<li class="next">';
			if( get_next_posts_link() ){
				next_posts_link( $older );
			}else{
				echo wp_kses_post( '<span>'.$older.'</span>' );
			}
			echo '</li>';
		echo '</ul>';
	}
	
?>