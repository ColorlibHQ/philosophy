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

<section class="s-extra">

    <div class="row top">

        <div class="col-eight md-six tab-full popular">
            <?php
            // Title
            $title = philosophy_opt( 'footer_top_setting_title_one' ); 
            if( $title ){
                echo philosophy_heading_tag(
                    array(
                        'tag' => 'h3',
                        'text'  => esc_html( $title ),
                    )
                );
            }
            ?>

            <div class="block-1-2 block-m-full popular__posts">
                <?php 
                $postNumber = philosophy_opt( 'footer_top_setting_content_one' );
                $args = array(
                    'posts_per_page' => esc_html( $postNumber ), 
                    'meta_key'       => 'philosophy_post_views_count', 
                    'orderby'        => 'meta_value_num', 
                    'order'          => 'DESC'  
                );

                $popularpost = new WP_Query( $args );
                if( $popularpost->have_posts() ):
                    while( $popularpost->have_posts() ): $popularpost->the_post();
                ?>
                <article class="col-block popular__post">
                    <?php
                    if( has_post_thumbnail() ):
                    ?>
                    <a href="<?php the_permalink(); ?>" class="popular__thumb">
                        <?php the_post_thumbnail(); ?>
                    </a>
                    <?php
                    endif;
                    //
                    the_title( sprintf( '<h5><a href="%s">', get_the_permalink() ), '</a></h5>' ); 
                    ?>
                    <section class="popular__meta">
                        <span class="popular__author"><span><?php esc_html_e( 'By', 'philosophy' ); ?></span> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>
                        <span class="popular__date"><span><?php esc_html_e( 'on', 'philosophy' ); ?></span> <time datetime="<?php echo esc_attr( get_the_date() ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>
                    </section>
                </article>
                <?php 
                    endwhile;
                endif;
                ?>
            </div> <!-- end popular_posts -->
        </div> <!-- end popular -->
        
        <div class="col-four md-six tab-full about">
            <?php 
            // Title
            $title = philosophy_opt('footer_top_setting_title_two');
            if( $title ){
                echo philosophy_heading_tag(
                    array(
                        'tag' => 'h3',
                        'text'  => esc_html( $title ),
                    )
                );
            }
            // Descriptions
            $desc = philosophy_opt( 'footer_top_setting_content_two' );
            if( $desc ){
                echo philosophy_get_textareahtml_output( $desc );
            }
            // Social Icon
            if( has_nav_menu( 'social-menu' ) && philosophy_opt( 'footer_top_setting_social_two' ) ){
                $args = array(
                    'theme_location' => 'social-menu',
                    'container'      => '',
                    'depth'          => 1,
                    'menu_class'     => 'about__social',
                    'fallback_cb'    => 'philosophy_social_navwalker::fallback',
                    'walker'         => new philosophy_social_navwalker(),
                );  
                wp_nav_menu( $args );
            }
            ?>
        </div> <!-- end about -->

    </div> <!-- end row -->
    <?php
    $tag = philosophy_opt('philosophy_footer_tag_enable'); 
    
    if( $tag ):
    ?>
    <div class="row bottom tags-wrap">
        <div class="col-full tags">

            <?php 
            // Title
            $title = philosophy_opt('footer_top_setting_title_three');
            if( $title ){
                echo philosophy_heading_tag(
                    array(
                        'tag' => 'h3',
                        'text'  => esc_html( $title ),
                    )
                );
            }
            ?>

            <div class="tagcloud">
                <?php 
                $tags = get_terms( 'post_tag', array(
                                'hide_empty' => false,
                            ) );

                $getTags = '';
                if( is_array( $tags ) && count( $tags ) > 0 ){

                    foreach( $tags as $tag ){
                        $getTags .= '<a href="'.esc_url( get_tag_link( $tag->term_id ) ).'">'.esc_html( $tag->name ).'</a>';
                    }
                }

                echo wp_kses_post( $getTags );
           
                ?>
            </div> <!-- end tagcloud -->
        </div> <!-- end tags -->
    </div> <!-- end tags-wrap -->
    <?php 
    endif;
    ?>

</section> <!-- end s-extra -->