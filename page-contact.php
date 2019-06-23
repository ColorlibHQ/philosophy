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

$lat    = philosophy_opt( 'philosophy_contact_latitude' );
$long   = philosophy_opt( 'philosophy_contact_longitude' );
$marker = philosophy_opt( 'philosophy_map_marker' );


?>
    <!-- s-content
    ================================================== -->
    <section class="s-content s-content--narrow">

        <div class="row">
            <?php
            // Page top title
            $pagetitle = philosophy_opt( 'philosophy_contact_top_title' ); 
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
                    <?php 

                    $contactinfo = philosophy_opt( 'philosophy_contact_infoblock');
                    //
                    if( is_array( $contactinfo ) && count( $contactinfo ) > 0 ):
                        foreach( $contactinfo as $info ):
                    ?>
                    <div class="col-six tab-full">
                        <?php 
                        if( !empty( $info['info_title'] ) ){
                            echo philosophy_heading_tag(
                                array(
                                    'tag'      => 'h3',
                                    'text'    => esc_html( $info['info_title'] )
                                )
                            );
                        }
                        // Information
                        if( !empty( $info['contact_info'] ) ){
                            echo philosophy_get_textareahtml_output( $info['contact_info'] );
                        }
                        ?>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div> <!-- end row -->
                <?php
                // Form Title
                $title = philosophy_opt('philosophy_contact_formtitle'); 
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
                $form7shortcode = philosophy_opt('philosophy_contact_formshortcode');
                $formcs         = philosophy_opt('philosophy_contact_custom_formshortcode');

                if( $form7shortcode && $form7shortcode != 'cs' ){
                    $form = '[contact-form-7 id="'.esc_html( $form7shortcode ).'" title="'.esc_html( get_the_title( $form7shortcode ) ).'"]';
                }else{
                    $form = $formcs;
                }
                //
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