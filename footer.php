<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package philosophy
 */

$facebookurl = !empty(get_theme_mod( 'philosophy_header_facebook_url_setting' )) ? get_theme_mod( 'philosophy_header_facebook_url_setting' ) : '';
$twitterurl = !empty(get_theme_mod( 'philosophy_header_twitter_url_setting' )) ? get_theme_mod( 'philosophy_header_twitter_url_setting' ) : '';
$instagramurl = !empty(get_theme_mod( 'philosophy_header_instagram_url_setting' )) ? get_theme_mod( 'philosophy_header_instagram_url_setting' ) : '';
$pinteresturl = !empty(get_theme_mod( 'philosophy_header_pinterest_url_setting' )) ? get_theme_mod( 'philosophy_header_pinterest_url_setting' ) : '';
$popular_post_count = get_theme_mod( 'footer_top_setting_content_one' );

$tag_count = get_theme_mod( 'footer_top_setting_tag_count' );

?>

	</div><!-- #content -->



    <?php if( get_theme_mod( 'philosophy_footer_top_enable' ) ): ?>
    <!-- s-extra
    ================================================== -->
    <section class="s-extra footer-enable">

        <div class="row top">

            <div class="col-eight md-six tab-full popular">
                <h3 class="popular-post-title"><?php echo esc_html( get_theme_mod( 'footer_top_setting_title_one' )); ?></h3>

                <div class="block-1-2 block-m-full popular__posts">
                <?php

                $popular_post = new WP_Query(array(
                    'posts_per_page' => $popular_post_count,
                    'meta_key'=>'popular_posts',
                    'orderby'=>'meta_value_num',
                    'order'=>'DESC',
                    'ignore_sticky_posts' => true
                ));

                while($popular_post->have_posts()) : $popular_post->the_post();  ?>

                    <article class="col-block popular__post">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="popular__thumb">
                               <?php the_post_thumbnail( 'philosophy_recent_post_thumb_size' ); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php the_permalink(); ?>" class="popular__thumb">
                               <img src="<?php  echo esc_url( get_template_directory_uri().'/assets/images/placeholder.png' ); ?>" alt="<?php the_title(); ?>">
                            </a>
                        <?php endif ?>

                        <h5><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 5,'...'); ?></a></h5>
                        <section class="popular__meta">
                                <span class="popular__author"><span><?php esc_html_e( 'By', 'philosophy' ); ?></span> <a href="<?php echo esc_attr( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"> <?php echo esc_html( get_the_author() ) ?></a></span>
                            <span class="popular__date"><span><?php esc_html_e( 'on', 'philosophy' ); ?></span> <time datetime="<?php the_time('F j, Y'); ?>"><?php the_time('F j, Y'); ?></time></span>
                        </section>
                    </article>

                <?php endwhile; ?>


                </div> <!-- end popular_posts -->
            </div> <!-- end popular -->

            <div class="col-four md-six tab-full about">
                <h3 class="about-post-title"><?php echo esc_html( get_theme_mod( 'footer_top_setting_title_two' )); ?></h3>

                <p class="about-post-content"><?php echo philosophy_get_textareahtml_output( get_theme_mod( 'footer_top_setting_content_two' )); ?></p>

                <?php if( get_theme_mod( 'footer_top_setting_social_two' ) ): ?>

                <ul class="about__social">
                    <?php if ($facebookurl): ?>
                    <li>
                        <a href="<?php echo esc_url( $facebookurl ); ?>"><i class="header-top-facebook fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <?php endif ?>

                   <?php if ($twitterurl): ?>
                    <li>
                        <a href="<?php echo esc_url( $twitterurl ); ?>"><i class="header-top-twitter fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <?php endif ?>

                   <?php if ($instagramurl): ?>
                    <li>
                        <a href="<?php echo esc_url( $instagramurl ); ?>"><i class="header-top-instagram fa fa-instagram" aria-hidden="true"></i></a>
                    </li>
                    <?php endif ?>

                   <?php if ($pinteresturl): ?>
                    <li>
                        <a href="<?php echo esc_url( $pinteresturl ); ?>"><i class="header-top-pinterest fa fa-pinterest" aria-hidden="true"></i></a>
                    </li>
                   <?php endif ?>
                </ul> <!-- end header__social -->
            <?php endif ?>
            </div> <!-- end about -->

        </div> <!-- end row -->

        <div class="row bottom tags-wrap">
            <div class="col-full tags">
                <h3 class="tags-widget-title"><?php echo esc_html( get_theme_mod( 'footer_top_setting_title_three' )); ?></h3>

                <div class="tagcloud">
                     <?php
                         wp_tag_cloud(
                            array(
                                'number' => $tag_count,
                            )
                        );
                    ?>
                </div> <!-- end tagcloud -->
            </div> <!-- end tags -->
        </div> <!-- end tags-wrap -->

    </section> <!-- end s-extra -->

    <?php endif ?>


    <!-- s-footer
    ================================================== -->
    <footer class="s-footer">

    <?php if (is_active_sidebar( 'footer' ) ) { ?>

        <div class="s-footer__main">
            <div class="row">

                <?php if ( is_active_sidebar( 'footer' ) ) { ?>
                        <?php dynamic_sidebar( 'footer' ); ?>
                <?php } ?>

            </div>
        </div> <!-- end s-footer__main -->


    <?php } ?>


    <div class="s-footer__bottom">
        <div class="row">
            <div class="col-full">
                <div class="s-footer__copyright">
                    <span><?php echo wp_kses_post(get_theme_mod( 'footer_copyright_text_setting', '&copy; Copyrights. All Rights Reserved' )); ?> <?php printf( esc_html__( 'Theme by %1$s Powered by %2$s', 'philosophy' ), '<a href="http://colorlib.com/" target="_blank">Colorlib</a>', '<a href="http://wordpress.org/" target="_blank">WordPress</a>' );?></span>
                </div>

                <?php if( get_theme_mod('philosophy_gototop_setting') ): ?>
                    <div class="go-top">
                        <a class="smoothscroll" title="<?php echo esc_attr( 'Back to Top','philosophy' ); ?>" href="#top"></a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div> <!-- end s-footer__bottom -->

    </footer> <!-- end s-footer -->


    <?php if( get_theme_mod('philosophy_preloader_setting') ): ?>
    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader">
            <div class="line-scale">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
