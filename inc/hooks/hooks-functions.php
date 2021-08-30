<?php 
// Block direct access
if( !defined( 'ABSPATH' ) ){
	exit( 'Direct script access denied.' );
}
/**
 * @Packge 	   : Philosophy
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Before wrapper Preloader
	if( !function_exists('philosophy_site_preloader') ){
		function philosophy_site_preloader(){
			if( philosophy_opt('philosophy_preloader_toggle',1) ):
		?>
		    <div id="preloader">
		        <div id="loader">
		            <div class="line-scale">
		                <div></div>
		                <div></div>
		                <div></div>
		                <div></div>
		                <div></div>
		            </div>
		        </div>
		    </div>
    	<?php
			endif;
		}
	}

	// Header menu hook function 
	if( !function_exists( 'philosophy_header_cb' ) ){
		function philosophy_header_cb(){
			if( !is_404() ){

				echo '<section class="s-pageheader'.( is_home() && philosophy_opt( 'philosophy_hfblog_toggle' ) ? ' s-pageheader--home' : '' ).'">';
					get_template_part( 'templates/menu', 'bar' );
					if( is_home() && philosophy_opt( 'philosophy_hfblog_toggle' ) ){
						get_template_part( 'templates/home', 'header' );
					}
					
				echo '</section> ';
			}
			
		}
	}

	// Footer area hook function
	if( !function_exists( 'philosophy_footer_area' ) ){
		function philosophy_footer_area(){

			if( !is_404() ){
				// Footer top widgets
				get_template_part( 'templates/footer-top', 'widgets' );
			
				// Footer widgets and footer bottom copyright
				echo '<footer class="s-footer">';
				// Footer widget

				if( philosophy_opt( 'philosophy_footer_widget_toggle' ) ){
					get_template_part( 'templates/footer', 'widgets' );
				}
				
				// Footer bottom
				get_template_part( 'templates/footer', 'bottom' );	
				echo '</footer>';

				
			}
		}
	}


	// Blog, single, page, search, archive pages wrapper start hook function.
	if( !function_exists('philosophy_wrp_start_cb') ){
		function philosophy_wrp_start_cb(){
		
			//
			if( is_home() || is_archive() || is_search()  ){
				echo '<section class="s-content">';

				if( is_archive() || is_search() ){
					get_template_part( 'templates/page', 'header' );
				}

				echo '<div class="row masonry-wrap">';


			}else{
				echo '<section class="s-content s-content--narrow s-content--no-padding-bottom">';
			}
			
		}
	}
	// Blog, single, page, search, archive pages wrapper end hook function.
	if( !function_exists('philosophy_wrp_end_cb') ){
		function philosophy_wrp_end_cb(){
			
			if( is_home() || is_archive() || is_search() ){
				echo '</div></section>';
			}else{
				echo '</section>';
			}
			
		}
	}
	// Blog, single, search, archive pages column start hook function.
	if( !function_exists('philosophy_blog_col_start_cb') ){
		function philosophy_blog_col_start_cb(){
			
			$sidebarOpt = philosophy_sidebar_opt();

			if( is_home() || is_archive() || is_search() ){

				// col start
				if( $sidebarOpt && $sidebarOpt != '1' ){
					// 
					$fright = '';
					if( $sidebarOpt == '3' ){
						$fright = ' ph-pull-right';
					}
					echo '<div class="col-nine'.esc_attr( $fright ).'">';
				}
				// masonry start
				echo '<div class="masonry">';
			}
			
		}
	}
	// Blog, single, search, archive pages column end hook function.
	if( !function_exists('philosophy_blog_col_end_cb') ){
		function philosophy_blog_col_end_cb(){
			if( is_home() || is_archive() || is_search() ){

				// masonry end
				echo '</div>';

				/**
				 * 
				 * Hook for Blog pagination
				 *
				 * Hook philosophy_blog_pagination
				 *
				 * @Hooked philosophy_blog_pagination_cb
				 *  
				 */
				do_action( 'philosophy_blog_pagination' );


				// Col end
				$sidebarOpt = philosophy_sidebar_opt();
				if( $sidebarOpt != '1' ){
					echo '</div>'; 
				}
			}
		}
	}

	// Blog post thumbnail hook function.
	if( !function_exists('philosophy_blog_posts_thumb_cb') ){
		function philosophy_blog_posts_thumb_cb(){
			// Thumbnail Show
			if( has_post_thumbnail() ){
						
				if( !is_single() ){
				
					$html = '';
					$html .= '<div class="entry__thumb">';
					$html .= '<a href="'.esc_url( get_the_permalink() ).'" class="entry__thumb-link">';
					$html .= philosophy_img_tag(
						array(
							'url' => esc_url( get_the_post_thumbnail_url() )
						)
					);
					$html .= '</a>';
					$html .= '</div>';
				
				}else{
					
					$html = '';
					$html .= '<div class="s-content__media col-full"><div class="s-content__post-thumb">';
					$html .= philosophy_img_tag(
						array(
							'url' => esc_url( get_the_post_thumbnail_url() )
						)
					);
					$html .= '</div></div>';

				}

				echo wp_kses_post( $html );
				
			}
			// Thumbnail check and video and audio thumb show
			if( !is_single() && !has_post_thumbnail() ){
				$html = '';
				if( has_post_format( array( 'video' ) ) ){
					
					$html .= '<div class="entry__thumb">';
					$html .= philosophy_embedded_media( array( 'video', 'iframe' ) );
					$html .= '</div>';

				}else{

					if( has_post_format( array( 'audio' ) ) ){
						
						$html .= '<div class="entry__thumb">';
						$html .= philosophy_embedded_media( array( 'audio', 'iframe' ) );
						$html .= '</div>';
					}
				}
				
				echo apply_filters( 'philosophy_audio_embedded_media', $html );

			}
			
		}
	}

	// Blog post title hook function.
	if( !function_exists('philosophy_blog_posts_title_cb') ){
		function philosophy_blog_posts_title_cb(){
			if( get_the_title() ){

				if( !is_single() ){
					echo '<h1 class="entry__title"><a href="'.esc_url( get_the_permalink() ).'">'.esc_html( get_the_title() ).'</a></h1>';
				}else{

				echo '<div class="s-content__header col-full">';

					echo '<h1 class="s-content__header col-full">'.esc_html( get_the_title() ).'</h1>';

					/**
					 * Blog Post Meta
					 * @Hook  philosophy_blog_posts_meta
					 *
					 * @Hooked philosophy_blog_posts_meta_cb
					 * 
					 *
					 */
					do_action( 'philosophy_blog_posts_meta' );

	            echo '</div>';

				}
				
			}
		}
	}

	// Blog posts meta hook function.
	if( !function_exists('philosophy_blog_posts_meta_cb') ){
		function philosophy_blog_posts_meta_cb(){

				if( !is_single() ){
					// Date
					if( get_the_date() ){
						echo '<div class="entry__date">';
						$postData = '<a href="'.esc_url( philosophy_blog_date_permalink() ).'">'.esc_html( get_the_date() ).',</a>';
						echo wp_kses_post( $postData );

						echo '</div>';
					}
				}else{

                echo '<ul class="s-content__header-meta">';
                    echo '<li class="date"><a href="'.esc_url( philosophy_blog_date_permalink() ).'">'.esc_html( get_the_date() ).',</a></li>';

            		echo philosophy_post_cats(array(
				        'wrp_start'         => '<li class="cat">',
				        'wrp_end'           => '</li>',
				        'label'				=> esc_html__( 'In', 'philosophy' ),
				        'tag'               => 'a',
				        'link'              => true,
					));
                echo '</ul>';

				}
			
		}
	}

	// Blog posts excerpt hook function.
	if( !function_exists('philosophy_blog_posts_excerpt_cb') ){
		function philosophy_blog_posts_excerpt_cb(){
			?>
			<div class="entry__excerpt">
				<?php 
				// Post excerpt
				echo philosophy_excerpt_length( esc_html( philosophy_opt('philosophy_excerpt_length') ) );

				// Link Pages
				philosophy_link_pages();
				?>
			</div>	
			<a href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Read More', 'philosophy' ); ?>
			</a>	
			<?php 
			// // Post category
			$cats = get_the_category();
			$categories = '';
			if( is_array( $cats ) && count( $cats ) > 0 ){
				echo '<div class="entry__meta"><span class="entry__meta-links">';
				
				foreach( $cats as $cat ){
				   $categories .= '<a href="'.esc_url( get_category_link( $cat->term_id ) ).'">'.esc_html( $cat->name ).',</a>';
				}
				echo wp_kses_post( $categories );
				echo '</span></div>';
			}

		}
	}

	// Blog pagination hook function.
	if( !function_exists('philosophy_blog_pagination_cb') ){
		function philosophy_blog_pagination_cb(){
			// Pagination
			get_template_part( 'templates/pagination' );
		}
	}

	// Blog posts content hook function.
	if( !function_exists('philosophy_blog_posts_content_cb') ){
		function philosophy_blog_posts_content_cb(){

			echo '<div class="col-full s-content__main">';

				the_content();
				// Link Pages
				philosophy_link_pages();

			// Single page meta
			do_action('philosophy_blog_single_meta');

			echo '</div>';


		}
	}

	// Page content hook function.
	if( !function_exists('philosophy_page_content_cb') ){
		function philosophy_page_content_cb(){
			?>
			<div class="page-content">
				<div class="s-content__header col-full">
	                <h1 class="s-content__header-title">
	                    <?php the_title(); ?>
	                </h1>
	            </div>
	            <?php 
	            if( has_post_thumbnail() ):
	            ?>
	            <div class="s-content__media col-full">
	                <div class="s-content__post-thumb">
	                    <?php the_post_thumbnail() ?>
	                </div>
	            </div>
	            <?php 
	        	endif;
	            ?>
				<div class="col-full s-content__main">
					<?php 
					the_content();

					// Link Pages
					philosophy_link_pages();
					?>

				</div>
			</div>
			<?php
			// comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	}

	// Blog page sidebar hook function.
	if( !function_exists('philosophy_blog_sidebar_cb') ){
		function philosophy_blog_sidebar_cb(){
			
			$sidebarOpt = philosophy_sidebar_opt();			
		
			if( $sidebarOpt && $sidebarOpt != '1' ){
				get_sidebar();
			}
							
		}
	}

	// Blog single post  social share hook function.
	if( !function_exists('philosophy_blog_posts_share_cb') ){
		function philosophy_blog_posts_share_cb(){
						
			if( function_exists('philosophy_social_sharing_buttons') ){
			
				philosophy_social_sharing_buttons();
				
			}			
		}
	}

	/**
	 * Blog single post meta category, tag, next-previous link, comments form and biography hook function.
	 */
	if( !function_exists('philosophy_blog_single_meta_cb') ){
		function philosophy_blog_single_meta_cb(){
						
			$tags = philosophy_post_tags();
	
			if( $tags ){

				echo '<p class="s-content__tags">';
					echo '<span>'.esc_html__( 'Post Tags:', 'philosophy' ).'</span>';
					echo '<span class="s-content__tag-list">';
					// single post tag
					echo wp_kses_post( $tags );
					
					echo '</span>';
				echo '</p>';
			}

			// Author biography
			if( '' !== get_the_author_meta('description') ){
				get_template_part( 'templates/biography' );
			}
			//
			if( get_next_post_link() || get_previous_post_link()  ):
			?>
            <div class="s-content__pagenav">
                <div class="s-content__nav">
                	<?php 
                	if( get_previous_post_link() ):
                	?>
                    <div class="s-content__prev">
                    	<?php
                    	previous_post_link( $format = '%link', $link = '<span>'.esc_html__( 'Previous Post', 'philosophy' ).'</span> %title', $in_same_term = false, $excluded_terms = '' );
                    	?>
                    </div>
                    <?php 
                	endif;
                	//
                	if( get_next_post_link() ):
                    ?>
                    <div class="s-content__next">
                    	<?php 
                    	next_post_link( $format = '%link', $link = '<span>'.esc_html__( 'Next Post', 'philosophy' ).'</span> %title', $in_same_term = false, $excluded_terms = '' );
                    	?>
                    </div>
                    <?php 
                	endif;
                    ?>
                </div>
            </div> <!-- end s-content__pagenav -->
			<?php
			endif;
	
		}
	}

	// Blog 404 page hook function.
	if( !function_exists('philosophy_fof_cb') ){
		function philosophy_fof_cb(){
			get_template_part( 'templates/404' );			
		}
	}

?>