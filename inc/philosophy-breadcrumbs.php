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

if ( ! function_exists( 'philosophy_breadcrumbs' ) ) {
    function philosophy_breadcrumbs( $args = array() ) {
        if ( is_front_page() ) {
            return;
        }
        if ( get_theme_mod( 'ct_ignite_show_breadcrumbs_setting' ) == 'no' ) {
            return;
        }
        global $post;
        $defaults  = array(
            'breadcrumbs_id'      => '',
            'breadcrumbs_classes' => esc_html( 'breadcrumb' ),
            'home_title'          => esc_html__( 'Home', 'philosophy' )
        );
        $args      = apply_filters( 'philosophy_breadcrumbs_args', wp_parse_args( $args, $defaults ) );
                
        $args_el = array();
        
        if( $args['breadcrumbs_id'] ){
            
            $args_el[] =  'id="'.esc_attr( $args['breadcrumbs_id'] ).'"';
        }
        
        if( $args['breadcrumbs_classes'] ){
            
            $args_el[] =  'class="'.esc_attr( $args['breadcrumbs_classes'] ).'"';
            
        }
        
        /*
        * Begin Markup 
        */
        
        // Open the breadcrumbs
        $html  = '<nav aria-label="breadcrumb">';
        $html  .= '<ol class="breadcrumb">';
        // Add Homepage link (always present)
        $html .= '<li class="breadcrumb-item"><a class="bread-link s-text16 bread-home" href="' . esc_url( get_home_url('/') ) . '" title="' . esc_attr( $args['home_title'] ) . '">'.esc_html__( 'Home', 'philosophy' ).' </a></li>';
        // Post
        if ( is_singular( 'post' ) ) {
            $category = get_the_category();
            $category_values = array_values( $category );
            $last_category = end( $category_values );
            $cat_parents = rtrim( get_category_parents( $last_category->term_id, true, '' ), ',' );
            $cat_parents = explode( ',', $cat_parents );
            foreach ( $cat_parents as $parent ) {
                $html .= wp_kses_post( '<li class="breadcrumb-item active">'.$parent.'</li>' );         
            }
            $html .= '<li class="breadcrumb-item bread-' . esc_attr( $post->ID ) . '" title="' . esc_attr( get_the_title() ) . ' active" aria-current="page">' . esc_html( get_the_title() ) . '</li>';
        } elseif ( is_singular( 'page' ) ) {
            if ( $post->post_parent ) {
                $parents = get_post_ancestors( $post->ID );
                $parents = array_reverse( $parents );
                foreach ( $parents as $parent ) {
                    $html .= '<li class="breadcrumb-item"><a class="bread-parent s-text16 bread-parent-' . esc_attr( $parent ) . '" href="' . esc_url( get_permalink( $parent ) ) . '" title="' . esc_attr( get_the_title( $parent ) ) . '">' . esc_html( get_the_title( $parent ) ) . '</li></a>';
                }
            }
            $html .= '<li class="breadcrumb-item active" aria-current="page">'.esc_html( get_the_title() ).'<li>';
        } elseif ( is_singular( 'attachment' ) ) {
            $parent_id        = $post->post_parent;
            $parent_title     = get_the_title( $parent_id );
            $parent_permalink = esc_url( get_permalink( $parent_id ) );
            $html .= '<li class="breadcrumb-item active" aria-current="page"><a class="bread-parent" href="' . esc_url( $parent_permalink ) . '" title="' . esc_attr( $parent_title ) . '">' . esc_attr( $parent_title ) . '</a></li>';
            $html .= '<span class="s-text17" title="' . esc_attr( get_the_title() ) . '"> ' . esc_html( get_the_title() ) . '</span>';
        } elseif ( is_singular() ) {
            $post_type         = get_post_type();
            $post_type_object  = get_post_type_object( $post_type );
            $post_type_archive = get_post_type_archive_link( $post_type );
            $html .= '<li class="breadcrumb-item active" aria-current="page"><a class="bread-cat s-text16 bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_attr( $post_type_object->labels->name ) . ' <i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i></a></li>';
            $html .= '<span class="s-text17 bread-' . $post->ID . '" title="' . $post->post_title . '">' . $post->post_title . '</span>';
			
        } elseif ( is_category() ) {
            $parent = get_queried_object()->category_parent;
            if ( $parent !== 0 ) {
                $parent_category = get_category( $parent );
                $category_link   = get_category_link( $parent );
                $html .= '<li class="breadcrumb-item active" aria-current="page"><a class="bread-parent bread-parent-' . esc_attr( $parent_category->slug ) . '" href="' . esc_url( $category_spannk ) . '" title="' . esc_attr( $parent_category->name ) . '">' . esc_attr( $parent_category->name ) . '</a></li>';
            }
            $html .= '<li class="breadcrumb-item active" title="' . $post->ID . '">' . single_cat_title( '', false ) . '</li>';
        } elseif ( is_tag() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . single_tag_title( '', false ) . '</li>';
        } elseif ( is_author() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . get_queried_object()->display_name . '</li>';
        } elseif ( is_day() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . get_the_date() . '</li>';
        } elseif ( is_month() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . get_the_date( 'F Y' ) . '</li>';
        } elseif ( is_year() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . get_the_date( 'Y' ) . '</li>';
        } elseif ( is_archive() ) {			
            $custom_tax_name = get_queried_object()->name;
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . esc_attr( $custom_tax_name ) . '</li>';
        } elseif ( is_search() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">'.esc_html__('Search results for:','philosophy') . get_search_query() . '</li>';
        } elseif ( is_404() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( 'Error 404', 'philosophy' ) . '</li>';
        } elseif ( is_home() ) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . get_the_title( get_option( 'page_for_posts' ) ) . '</li>';
        }
        $html .= '</ol>';
        $html .= '</nav>';
        $html = apply_filters( 'philosophy_breadcrumbs_filter', $html );
		
		echo wp_kses_post( $html );	
	
        
    }
}
