<?php

// Customize CSS
function philosophy_customize_css()
{
    ?>
         <style type="text/css">
             .s-pageheader::before { 
             	background-color: <?php echo get_theme_mod('philosophy_navbar_bgcolor_setting', '#151515'); ?>; 
             }
             .s-content {
             	background-color: <?php echo get_theme_mod('philosophy_content_bgcolor_setting', '#f2f2f2'); ?>
             }
             .comments-wrap {
             	background-color: <?php echo get_theme_mod('philosophy_comment_bgcolor_setting', '#e5e5e5'); ?>
             }
             .s-footer {
             	background: <?php echo get_theme_mod('philosophy_footer_bgcolor_setting', '#19191b'); ?>
             }
			 footer h4 {
				 color: <?php echo get_theme_mod('philosophy_footer_titlecolor_setting', '#fff'); ?>
			 }
			 footer a,
			 .footer-widget a {
				color: <?php echo get_theme_mod('philosophy_footer_anchorcolor_setting', '#fff'); ?>
			 }
			 footer a:hover,
			 .footer-widget a:hover {
				color: <?php echo get_theme_mod('philosophy_footer_anchorhovcolor_setting', '#fff'); ?>
			 }
			 .footer-widget,
			 .footer-widget p,
			 .s-footer__bottom .s-footer__copyright span {
				color: <?php echo get_theme_mod('philosophy_footer_textcolor_setting', '#fff'); ?>
			 }
         </style>
    <?php
}
add_action( 'wp_head', 'philosophy_customize_css');

// philosophy demo import
function philosophy_import_files() {
  return array(
    array(
      'import_file_name'             => esc_html__( 'Demo Import', 'philosophy' ),
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-import/content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-import/widgets.wie',
      'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-import/customizer.dat',
      'import_notice'                => esc_html__( 'After you import this demo, you will have to enable banner separately.', 'philosophy' ),
    )
  );
}
add_filter( 'pt-ocdi/import_files', 'philosophy_import_files' );


// Custom embedded media
function philosophy_get_embedded_media($type = array())
{
    $content = do_shortcode(apply_filters('the_content', get_the_content()));
    $embed = get_media_embedded_in_content($content, $type);

    if (in_array('audio', $type)):
        $output = str_replace('?visual=true', '?visual=false', $embed[0]); else:
        $output = $embed[0];
    endif;

    return $output;
}


#
#  Move comment field to bottom
#
add_filter( 'comment_form_fields', 'philosophy_lite_move_comment_field_to_bottom' );
function philosophy_lite_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

// Custom pagination

function philosophy_pagination() {

global $wp_query;

$big = 999999999; // need an unlikely integer

$pages = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'type'  => 'array',
    ) );
    if( is_array( $pages ) ) {
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<nav class="pgn"><ul class="pagination">';
        foreach ( $pages as $page ) {
                echo "<li>$page</li>";
        }
       echo '</ul></nav>';
        }
}

//Change excerpt length
function philosophy_excerpt_length( $length ) {
	
	return 30;
}
add_filter( 'excerpt_length', 'philosophy_excerpt_length', 999 );
//Change excerpt dots
function philosophy_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'philosophy_excerpt_more');



// Flat Content wysiwyg output with meta key and post id
function philosophy_get_textareahtml_output( $content ) {
    
    global $wp_embed;

    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = wpautop( $content );
    $content = do_shortcode( $content );

    return $content;
}