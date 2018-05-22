<?php

// Custom comments list
function philosophy_comment($comment, $args, $depth) { 

	if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }?>
    <<?php echo esc_html($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
    if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>

        <div class="comment__avatar">
                <?php 
                if ( $args['avatar_size'] != 0 ) {
                    echo get_avatar( $comment, $args['avatar_size'] ); 
                } ?>
        </div>

        <div class="comment__content">

            <div class="comment__info">
                <?php printf( '<cite>%s</cite>' , get_comment_author_link() ); ?>

                <div class="comment__meta">
                    <time class="comment__time"><?php echo esc_html( get_comment_date().' @ '.  
                    get_comment_time()); ?></time>
                   <?php 
	                comment_reply_link( 
	                    array_merge( 
	                        $args, 
	                        array( 
	                            'add_below' => $add_below, 
	                            'depth'     => $depth, 
	                            'max_depth' => $args['max_depth'] 
	                        ) 
	                    ) 
	                ); ?>
                </div>
            </div>

            <div class="comment__text">
           		<?php comment_text(); ?>
           		<?php  edit_comment_link('(Edit)','  ', '' ); ?>
            </div>

        </div>

   <?php 
    if ( 'div' != $args['style'] ) : ?>
        </div>
        <?php 
    endif;
}
