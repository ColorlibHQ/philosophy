<?php
/**
 * Template part for displaying about page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

?>


    <section class="s-content s-content--narrow">

        <div class="row">

            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    <?php the_title() ?>
                </h1>
            </div> <!-- end s-content__header -->

            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                    <?php the_post_thumbnail() ?>
                </div>
            </div> <!-- end s-content__media -->

            <div class="col-full s-content__main">
                <?php the_content(); ?>

                <div class="row block-1-2 block-tab-full">
                    <div class="col-block">
                        <h3 class="quarter-top-margin col-block-one-title"><?php echo get_theme_mod('about_block_setting_title_one'); ?></h3>
                        <div class="col-block-one-content"><?php echo philosophy_get_textareahtml_output( get_theme_mod('about_block_setting_content_one') ); ?></div>
                    </div>

                    <div class="col-block">
                        <h3 class="quarter-top-margin col-block-two-title"><?php echo get_theme_mod('about_block_setting_title_two'); ?></h3>
                        <div class="col-block-two-content"><?php echo philosophy_get_textareahtml_output( get_theme_mod('about_block_setting_content_two') ); ?></div>
                    </div>

                    <div class="col-block">
                        <h3 class="quarter-top-margin col-block-three-title"><?php echo get_theme_mod('about_block_setting_title_three'); ?></h3>
                        <div class="col-block-three-content"><?php echo philosophy_get_textareahtml_output( get_theme_mod('about_block_setting_content_three') ); ?></div>
                    </div>

                    <div class="col-block">
                        <h3 class="quarter-top-margin col-block-four-title"><?php echo get_theme_mod('about_block_setting_title_four'); ?></h3>
                        <div class="col-block-four-content"><?php echo philosophy_get_textareahtml_output( get_theme_mod('about_block_setting_content_four') ); ?></div>
                    </div>

                </div>


            </div> <!-- end s-content__main -->

        </div> <!-- end row -->

    </section> <!-- s-content -->


