<!-- Fotter Bottom Area -->
<div class="s-footer__bottom">
    <div class="row">
        <div class="col-full">
            <div class="s-footer__copyright">
                <?php 
                // Copy right text
                $copyText = sprintf( __( 'Copyright &copy; %s All rights reserved. | This template is made with %s by <a href="%s" target="_blank">Colorlib</a>', 'philosophy' ), date('Y') ,'<i class="fa fa-heart-o" aria-hidden="true"></i>', 'https://colorlib.com' );
                                            
                $setCopyright = philosophy_opt('philosophy_footer_copyright_text');
                
                if( $setCopyright ){
                    $copyText = $setCopyright;
                }
                 
                ?>
                <span><?php echo wp_kses_post( $copyText ); ?></span>
            </div>
            <?php
            if( philosophy_opt('philosophy_backtotop_btn',1) ):
            ?>
            <div class="go-top">
                <a class="smoothscroll" title="Back to Top" href="#top"></a>
            </div>
            <?php 
            endif;
            ?>
        </div>
    </div>
</div> <!-- end s-footer__bottom -->
