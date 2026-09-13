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

?>

<div class="pageheader-content row">
    <div class="col-full">
        <div class="featured">

            <div class="featured__column featured__column--big">
                <?php 
                $term = philosophy_opt( 'philosophy_featured_cat' );
                
                //
                $loop = new WP_Query( philosophy_featured_query_args( $term, 1, 0 ) );

                if( $loop->have_posts() ):
                    while( $loop->have_posts() ) : $loop->the_post(); 

                        $url    = get_author_posts_url( get_the_author_meta( 'ID' ) );
                        $avatar = get_avatar( get_the_author_meta( 'ID' ), 42 );

                ?>
                    <div class="entry" <?php echo philosophy_inline_bg_img( get_the_post_thumbnail_url( null, 'large' ) ); ?>>
                        
                        <div class="entry__content">
                            <?php 
                            if( philosophy_featured_post_cat() ){
                                echo '<span class="entry__category">'.wp_kses_post( philosophy_featured_post_cat() ).'</span>';
                            }
                            ?>
                            

                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                            <div class="entry__info<?php echo $avatar ? '' : ' entry__info--no-avatar'; ?>">
                                <?php if ( $avatar ) : ?>
                                <a href="<?php echo esc_url( $url ); ?>" class="entry__profile-pic">
                                    <?php echo $avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_avatar() returns escaped markup. ?>
                                </a>
                                <?php endif; ?>

                                <ul class="entry__meta">
                                    <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_author() ); ?></a></li>
                                    <li><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></li>
                                </ul>
                            </div>

                        </div> <!-- end entry__content -->
                        
                    </div> <!-- end entry -->
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div> <!-- end featured__big -->

            <div class="featured__column featured__column--small">
                <?php 
                $loop = new WP_Query( philosophy_featured_query_args( $term, 2, 1 ) );

                if( $loop->have_posts() ):
                    while( $loop->have_posts() ) : $loop->the_post(); 

                        $url = get_author_posts_url( get_the_author_meta( 'ID' ) );
                         
                ?>
                    <div class="entry" <?php echo philosophy_inline_bg_img( get_the_post_thumbnail_url( null, 'large' ) ); ?>>
                        
                        <div class="entry__content">
                            <?php 
                            if( philosophy_featured_post_cat() ){
                                echo '<span class="entry__category">'.wp_kses_post( philosophy_featured_post_cat() ).'</span>';
                            }
                            ?>                            
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                            <div class="entry__info">
                                <ul class="entry__meta">
                                    <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_author() ); ?></a></li>
                                    <li><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></li>
                                </ul>
                            </div>

                        </div> <!-- end entry__content -->
                        
                    </div> <!-- end entry -->

                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

            </div> <!-- end featured__small -->

        </div> <!-- end featured -->

    </div> <!-- end col-full -->
</div> <!-- end pageheader-content row -->