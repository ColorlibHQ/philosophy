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



$sidebar1 = is_active_sidebar( 'footer-1' );
$sidebar2 = is_active_sidebar( 'footer-2' );
$sidebar3 = is_active_sidebar( 'footer-3' );

// Check sidebar active
if( $sidebar1 || $sidebar2 || $sidebar3 ):
?>

<section class="s-extra">
    <?php 
    // Check is active sidebar 1 or 2

    if( $sidebar1 || $sidebar2 ):
    ?>
    <div class="row top">
        <?php 
        // Footer widget 1
        if( is_active_sidebar( 'footer-1' ) ){
            echo '<div class="col-eight md-six tab-full popular">';
                dynamic_sidebar( 'footer-1' );
            echo '</div>';
        }

        // Footer widget 2
        if( is_active_sidebar( 'footer-2' ) ){
            echo '<div class="col-four md-six tab-full about">';
                dynamic_sidebar( 'footer-2' );
            echo '</div>';
        }
        ?>

    </div>
    <?php 
    endif;
    
    // 
    if( $sidebar3 ):
    ?>
    <div class="row bottom tags-wrap">
        <?php
        // Footer widget 3
        if( is_active_sidebar( 'footer-3' ) ){
            echo '<div class="col-full tags">';
                dynamic_sidebar( 'footer-3' );
            echo '</div>';
        }
        ?>  
    </div>
    <?php 
    endif;
    ?>

</section> <!-- end s-extra -->
<?php 
endif;
?>