<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

$singe_blog_sidebar = get_theme_mod( 'single_blog_sidebar_setting' ) == 'single_with_sidebar' ? true : false;

?>


<?php if (is_single()) { ?>

<section class="s-content s-content--narrow s-content--no-padding-bottom">
   <article class="row format-standard">
    <?php if ( $singe_blog_sidebar == true ): ?>
        <div class="main-content-area">
    <?php endif ?>
            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    <?php the_title(); ?>
                </h1>
                <ul class="s-content__header-meta">
                    <li class="date"><?php the_time('M d, Y'); ?></li>
                    <li class="cat">
                        <?php esc_html_e( 'In', 'philosophy' ); ?>
                        <?php the_category( ', ' ); ?> 
                    </li>
                </ul>
            </div> <!-- end s-content__header -->
            
            <?php if (has_post_thumbnail()) {?>
                <div class="s-content__media col-full">
                    <div class="s-content__post-thumb">
                        <?php the_post_thumbnail() ?>
                    </div>
                </div> <!-- end s-content__media -->
             <?php } ?>
            

            <div class="col-full s-content__main">

                <?php the_content(); ?>
                <?php 
                    wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'philosophy' ),
                    'after'  => '</div>',
                ) ); ?>
                
                <?php 
                if ( has_tag() ): ?>
                    <div class="s-content__tags">
                        <span><?php esc_html_e( 'Post Tags', 'philosophy' ); ?></span>
                        <span class="s-content__tag-list"><?php the_tags('','',''); ?></span>
                    </div> <!-- end s-content__tags -->
                <?php endif ?>

                <div class="s-content__author">
                    

                    <?php 

                    $avater = get_avatar( get_the_author_meta( 'ID' ), 32 );

                        if ( $avater ) {
                            echo wp_kses_post( $avater );
                        }
                    
                    ?>

                    <div class="s-content__author-about">
                        <h4 class="s-content__author-name">
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php echo esc_html( get_the_author() ) ?></a>
                        </h4>
                        <?php 

                        $author_desc = get_the_author_meta( 'user_description', $post->post_author );

                        if ( '' !== $author_desc ) { ?>
                            <p><?php echo esc_html( $author_desc ); ?></p>
                        <?php } ?>

                    </div>
                </div>


                <div class="s-content__pagenav">
                    <div class="s-content__nav">
  					<?php 
					// Previous
					if( get_previous_post_link() ){
												
						echo '<div class="s-content__prev">';
						echo get_previous_post_link( '%link', '<span>'.esc_html__( 'Previous Post', 'philosophy' ).'</span> %title', false );
						echo '</div>';
					}
					
					// Next
					if( get_next_post_link() ){
						echo '<div class="s-content__next">';
						echo get_next_post_link( '%link', '<span>'.esc_html__( 'Next Post', 'philosophy' ).'</span> %title', false );
						echo '</div>';
					}
					?>
                    </div>
                </div> <!-- end s-content__pagenav -->

            </div> <!-- end s-content__main -->

        <?php if ( $singe_blog_sidebar == true ): ?>
    		</div>
    		
    		<div class="sidebar-area">
    			<?php 
    			get_sidebar();
    			?>
    		</div>
        <?php endif ?>
		
        </article>


        <!-- comments
		================================================== -->
		<?php 
		if ( comments_open() || get_comments_number() ) :
		?>
        <div class="comments-wrap">
            <div id="comments" class="row">
                <?php 
                    // If comments are open or we have at least one comment, load up the comment template.
                     comments_template();
                ?>

            </div> <!-- end row comments -->
        </div> <!-- end comments-wrap -->
		<?php 
		endif;
		?>
    </section> <!-- s-content -->


    <?php } else { ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('masonry__brick entry'); ?> data-aos="fade-up">
        <div class="entry__thumb">
            <a href="<?php the_permalink(); ?>" class="entry__thumb-link">
                <?php the_post_thumbnail(); ?>
            </a>
        </div>

        <div class="entry__text">
            <div class="entry__header">
                
                <div class="entry__date">
                    <a href="<?php the_permalink(); ?>"><?php echo get_the_time( 'M d , Y' ); ?></a>
                </div>
                <h1 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                
            </div>
            <div class="entry__excerpt">
                <p>
                    <?php the_excerpt() ?>
                </p>
            </div>
            <div class="entry__meta">
                <span class="entry__meta-links">
                    <?php echo get_the_category_list( esc_html__( ', ', 'philosophy' ) ); ?>
                </span>
            </div>
        </div>
    </article>
    

<?php } ?>

