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
 * Template Name: Contact Page
 *
 */

get_header();

$lat    = philosophy_opt( 'philosophy_google_map_lat_setting' );
$long   = philosophy_opt( 'philosophy_google_map_long_setting' );
$marker = philosophy_opt( 'philosophy_google_map_marker' );

?>
    <!-- s-content
    ================================================== -->
    <section class="s-content s-content--narrow">

        <div class="row">
            <?php
            // Page top title
            $pagetitle = philosophy_opt( 'philosophy_contact_setting_page_title' ); 
            if( $pagetitle ){
                echo philosophy_heading_tag(
                    array(
                        'tag'      => 'h1',
                        'class'    => 's-content__header-title',
                        'text'    => esc_html( $pagetitle ),
                        'wrap_before' => '<div class="s-content__header col-full">',
                        'wrap_after'  => '</div>',
                    )
                );
            }
            ?>    
            <div class="s-content__media col-full">
                <div id="map-wrap" data-lat="<?php echo esc_attr( $lat ); ?>" data-long="<?php echo esc_attr( $long ); ?>" data-marker="<?php echo esc_url( $marker ); ?>">
                    <div id="map-container"></div>
                    <div id="map-zoom-in"></div>
                    <div id="map-zoom-out"></div>
                </div> 
            </div> <!-- end s-content__media -->

            <div class="col-full s-content__main">
                
                <?php 
                if( have_posts() ){
                    while( have_posts() ){
                        the_post();

                        the_content();
                    }
                }
                ?>

                <div class="row">
                    <div class="col-six tab-full">
                        <?php 
                        // Block #1 Title
                        $title = philosophy_opt('philosophy_contact_setting_block_title_one');
                        if( $title ){
                            echo philosophy_heading_tag(
                                array(
                                    'tag'      => 'h3',
                                    'text'    => esc_html( $title )
                                )
                            );
                        }
                        // Information
                        $info = philosophy_opt('philosophy_contact_setting_block_content_one');
                        if( $info ){
                            echo philosophy_get_textareahtml_output( $info );
                        }
                        ?>
                    </div>

                    <div class="col-six tab-full">
                        <?php
                        // Block #2
                        $title = philosophy_opt('philosophy_contact_setting_block_title_two'); 
                        if( $title ){
                            echo philosophy_heading_tag(
                                array(
                                    'tag'      => 'h3',
                                    'text'    => esc_html( $title )
                                )
                            );
                        }
                        // Info
                        $info = philosophy_opt('philosophy_contact_setting_block_content_two');
                        if( $info ){
                            echo philosophy_get_textareahtml_output( $info );
                        }
                        ?>

                    </div>
                </div> <!-- end row -->
                <?php
                // Form Title
                $title = philosophy_opt('philosophy_contact_setting_form_title'); 
                if( $title ){
                    echo philosophy_heading_tag(
                        array(
                            'tag'      => 'h3',
                            'class'    => 'form-title',
                            'text'    => esc_html( $title )
                        )
                    );
                }
                // contact form shortcode
                $form = philosophy_opt('philosophy_contact_form_setting');

                if( $form ){
                    echo do_shortcode( $form );
                }
                ?>

            </div> <!-- end s-content__main -->

        </div> <!-- end row -->

    </section> <!-- s-content -->

<?php 
get_footer();
?>