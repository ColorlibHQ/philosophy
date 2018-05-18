<?php
/**
 * Template part for displaying contact page
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
                    <?php the_title(); ?>
                </h1>
            </div> <!-- end s-content__header -->
    
            <div class="s-content__media col-full">
                <div id="map-wrap" data-lat="<?php echo esc_html( get_theme_mod( 'google_map_lat_setting', '37.422424' ) ); ?>" data-long="<?php echo esc_html( get_theme_mod( 'google_map_long_setting', '-122.085661' ) ); ?>" data-marker="<?php echo esc_url( get_theme_mod( 'google_map_marker' ) ); ?>">
                    <div id="map-container"></div>
                    <div id="map-zoom-in"></div>
                    <div id="map-zoom-out"></div>
                </div> 
            </div> <!-- end s-content__media -->

            <div class="col-full s-content__main">

                <?php the_content(); ?>

                <div class="row">
                    <div class="col-six tab-full">
                        <h3 class="c-block-title-one"><?php echo get_theme_mod( 'contact_setting_block_title_one' ) ?></h3>

                        <p class="c-block-content-one">
                            <?php echo philosophy_get_textareahtml_output( get_theme_mod( 'contact_setting_block_content_one' ) ) ?>
                        </p>

                    </div>

                    <div class="col-six tab-full">
                        <h3 class="c-block-title-two"><?php echo get_theme_mod( 'contact_setting_block_title_two' ) ?></h3>

                        <p class="c-block-content-two">
                            <?php echo philosophy_get_textareahtml_output( get_theme_mod( 'contact_setting_block_content_two' ) ) ?>
                        </p>

                    </div>
                </div> <!-- end row -->

                <h3 class="contact-form-title"><?php echo get_theme_mod( 'contact_form_title_setting' ) ?></h3>
                
                <div class="contact-form-7">
                    <?php echo philosophy_get_textareahtml_output( get_theme_mod( 'contact_form_setting' ) ) ?>
                </div>

            </div> <!-- end s-content__main -->

        </div> <!-- end row -->

    </section> <!-- s-content -->