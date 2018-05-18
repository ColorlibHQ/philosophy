<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package philosophy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="s-content__header col-full">
        
        <?php the_title( '<h1 class="s-content__header-title">', '</h1>' ); ?>
      
    </div> <!-- end s-content__header -->


	<?php if (has_post_thumbnail()) {?>
	       <div class="s-content__media col-full">
	        <div class="s-content__post-thumb">
	            <?php philosophy_post_thumbnail(); ?>
	        </div>
	    </div> <!-- end s-content__media -->   
	<?php } ?>
	

	<div class="col-full s-content__main">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'philosophy' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .s-content__main -->

	<?php if ( get_edit_post_link() ) : ?>
		<div class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'philosophy' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</div><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post--->
