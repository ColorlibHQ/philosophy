<div class="row narrow">
    <div class="col-full s-content__header aos-init aos-animate" data-aos="fade-up">
        <?php 
        if ( is_archive() ){
            the_archive_title('<h1>', '</h1>');
        }elseif ( is_home() ){
            echo '<h1>'.esc_html__( 'Blog', 'philosophy' ).'</h1>';
        }elseif(is_search()){
            echo '<h1>'.esc_html__( 'Search Result', 'philosophy' ).'</h1>';
        } else{
            the_title( '<h1>', '</h1>' );
        }
        // 
        $content = '';
        if( !is_archive() ){
            $content = philosophy_opt( 'philosophy_search_pageheader_content' );
        }else{
            $content = philosophy_opt( 'philosophy_archive_pageheader_content' );
        }
        //
        if( $content ){

            echo '<div class="lead">'.philosophy_get_textareahtml_output( $content ).'</div>';
        }
        ?>
    </div>
</div>