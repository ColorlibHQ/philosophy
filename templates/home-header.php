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
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 1,
                    'ignore_sticky_posts' => true,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => esc_html( ( $term ) ? $term : 'uncategorized'  ),
                        )
                    )
                );
                $loop = new WP_Query( $args );

                if( $loop->have_posts() ):
                    while( $loop->have_posts() ) : $loop->the_post(); 

                        $url = get_author_posts_url( get_the_author_meta( 'ID' ) );
                         

                ?>
                    <div class="entry" <?php echo philosophy_inline_bg_img( get_the_post_thumbnail_url() ); ?>>
                        
                        <div class="entry__content">
                            <?php 
                            if( philosophy_featured_post_cat() ){
                                echo '<span class="entry__category">'.philosophy_featured_post_cat().'</span>';
                            }
                            ?>
                            

                            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

                            <div class="entry__info">
                                <a href="<?php echo esc_url( $url ); ?>" class="entry__profile-pic">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 42 ); ?>
                                </a>

                                <ul class="entry__meta">
                                    <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_author() ); ?></a></li>
                                    <li><?php echo esc_attr( get_the_date() ); ?></li>
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
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 2,
                    'offset'         => 1,
                    'ignore_sticky_posts' => true,
                    'tax_query' => array(
                        array(
                            'taxonomy'  => 'category',
                            'field'     => 'slug',
                            'terms'     => esc_html( ( $term ) ? $term : 'uncategorized' ),
                        )
                    )
                );
                $loop = new WP_Query( $args );

                if( $loop->have_posts() ):
                    while( $loop->have_posts() ) : $loop->the_post(); 

                        $url = get_author_posts_url( get_the_author_meta( 'ID' ) );
                         
                ?>
                    <div class="entry" <?php echo philosophy_inline_bg_img( get_the_post_thumbnail_url() ); ?>>
                        
                        <div class="entry__content">
                            <?php 
                            if( philosophy_featured_post_cat() ){
                                echo '<span class="entry__category">'.philosophy_featured_post_cat().'</span>';
                            }
                            ?>                            
                            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

                            <div class="entry__info">
                                <ul class="entry__meta">
                                    <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_author() ); ?></a></li>
                                    <li><?php echo esc_attr( get_the_date() ); ?></li>
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