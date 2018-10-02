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
 * Template Name: About Page
 *
 */

get_header();
?>

    <!-- s-content
    ================================================== -->
    <section class="s-content s-content--narrow">
        <div class="row">
            <?php
            // Page top title
            $pagetitle = philosophy_opt( 'philosophy_about_top_title' ); 
            if( $pagetitle ){
                echo philosophy_heading_tag(
                    array(
                        'tag'         => 'h1',
                        'class'       => 's-content__header-title',
                        'text'        => esc_html( $pagetitle ),
                        'wrap_before' => '<div class="s-content__header col-full">',
                        'wrap_after'  => '</div>',
                    )
                );
            }
            //
            if( has_post_thumbnail() ):
            ?>
            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                    <?php 
                    the_post_thumbnail();
                    ?>
                </div>
            </div> <!-- end s-content__media -->
            <?php 
            endif;
            ?>
            <div class="col-full s-content__main">

                <?php 
                if( have_posts() ){
                    while( have_posts() ){
                        the_post();
                        the_content();
                    }
                }
                ?>

                <div class="row block-1-2 block-tab-full">
                <?php

                // 
                $aboutinfo = philosophy_opt('philosophy_about_infoblock');

                if( is_array( $aboutinfo ) && count( $aboutinfo ) > 0 ):
                    foreach( $aboutinfo as $info ):
                ?>
                    <div class="col-block">
                        <?php 
                        //
                        if( !empty( $info['info_title'] ) ){
                            echo philosophy_heading_tag(
                                array(
                                    'tag'   => 'h3',
                                    'class' => 'quarter-top-margin',
                                    'text'  => esc_html( $info['info_title'] )
                                )
                            );
                        }
                        //
                        if( !empty( $info['info_desc'] ) ){
                            echo philosophy_get_textareahtml_output( $info['info_desc'] );
                        }
                        ?>
                    </div>
                    <?php 
                    endforeach;
                endif;
                    ?>

                </div>


            </div> <!-- end s-content__main -->

        </div> <!-- end row -->

    </section> <!-- s-content -->

<?php 
get_footer();
?>