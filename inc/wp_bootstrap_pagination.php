<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

/**
 *
 * @Packge      Colorlib
 * @Author      Colorlib
 * @Author URL  https//www.Colorlib.com
 * @version     1.0
 *
 */
        
function philosophy_pagination( $args = array() ) {
    
    $defaults = array(
        'range'           => 4,
        'custom_query'    => FALSE,
        'before_output'   => '<div class="col-full"><nav class="pgn" aria-label="' . esc_attr__( 'Posts navigation', 'philosophy' ) . '"><ul>',
        'after_output'    => '</ul></nav></div>'
    );
    
    $args = wp_parse_args( 
        $args, 
        apply_filters( 'philosophy_pagination_defaults', $defaults )
    );
    
    $args['range'] = (int) $args['range'] - 1;
    if ( !$args['custom_query'] )
        $args['custom_query'] = isset( $GLOBALS['wp_query'] ) ? $GLOBALS['wp_query'] : '';
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range'] / 2 );
    
    if ( $count <= 1 )
        return FALSE;
    
    if ( !$page )
        $page = 1;
    
    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }
    
    $echo = '';
   
    
    $previous = intval($page) - 1;
    $previous = get_pagenum_link( $previous );
    
    if ( $previous && (1 != $page) )
        $echo .= '<li class="previous pgn__prev"><a href="' . esc_url( $previous ) . '">' . esc_html__( 'Previous', 'philosophy' ) . '</a></li>';
    
    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ( $page == $i ) {
                $echo .= '<li class="page-item"><span class="pgn__num current" aria-current="page">' . esc_html( str_pad( (int) $i, 2, '0', STR_PAD_LEFT ) ) . '</span></li>';
            } else {
                $echo .= sprintf(
                    '<li class="page-item"><a href="%1$s" class="pgn__num"><span class="screen-reader-text">%2$s </span>%3$02d</a></li>',
                    esc_url( get_pagenum_link( $i ) ),
                    esc_html__( 'Page', 'philosophy' ),
                    (int) $i
                );
            }
        }
    }
    
    $next = intval($page) + 1;
    $next = get_pagenum_link( $next );
    if ($next && ($count != $page) )
        $echo .= '<li class="next pgn__next"><a href="' . esc_url( $next ) . '">' . esc_html__( 'Next', 'philosophy' ) . '</a></li>';



    if ( isset($echo) )
        echo wp_kses_post( $args['before_output'] . $echo . $args['after_output'] );
    
}
