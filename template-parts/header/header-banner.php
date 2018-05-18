<div class="pageheader-content row">
    <div class="col-full">

        <div class="featured">

            <?php 
                $posts_one = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 1,
                'ignore_sticky_posts' => true,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-aside', 'post-format-gallery', 'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-status', 'post-format-audio', 'post-format-chat', 'post-format-video'),
                        'operator' => 'NOT IN'
                        )
                    )
                ));

            ?>
            <div class="featured__column featured__column--big">

            <?php

            if ( have_posts() ) :

                while($posts_one->have_posts()) : $posts_one->the_post();  ?>

                    <div class="entry" style="background-image:url('<?php if(has_post_thumbnail()){the_post_thumbnail_url();} else { echo get_template_directory_uri().'/assets/images/placeholder.png'; }  ?>');">
                        
                        <div class="entry__content">
                            <span class="entry__category"><?php the_category() ?></span>

                            <h1><a href="<?php the_permalink(); ?>" ><?php the_title() ?></a></h1>

                            <div class="entry__info">
                                <a href="<?php echo esc_attr( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>" class="entry__profile-pic">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 42 ); ?>
                                </a>

                                <ul class="entry__meta">
                                    <li><a href="<?php echo esc_attr( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php echo esc_html( get_the_author() ) ?></a></li>
                                    <li><?php the_time('M d, Y'); ?></li>
                                </ul>
                            </div>
                        </div> <!-- end entry__content -->
                        
                    </div> <!-- end entry -->
                
                <?php 

                endwhile; 

            endif;

             wp_reset_postdata(); 
             
            ?>

                    
            </div> <!-- end featured__big -->


            <div class="featured__column featured__column--small">
                <?php 
                    $posts_two = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => 2, 
                    'offset' => 1,
                    'ignore_sticky_posts' => true,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-aside', 'post-format-gallery', 'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-status', 'post-format-audio', 'post-format-chat', 'post-format-video'),
                                'operator' => 'NOT IN'
                            )
                        )
                ));

                ?>

                <?php

                if ( have_posts() ) :

                    while($posts_two->have_posts()) : $posts_two->the_post();  ?>

                        <div class="entry" style="background-image:url('<?php if(has_post_thumbnail()){the_post_thumbnail_url();} else { echo get_template_directory_uri().'/assets/images/placeholder.png'; }  ?>');">
                            
                            <div class="entry__content">
                                <span class="entry__category"><?php the_category() ?></span>

                                <h1><a href="<?php the_permalink(); ?>" ><?php the_title() ?></a></h1>

                                <div class="entry__info">
                                    <a href="<?php echo esc_attr( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>" class="entry__profile-pic">
                                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 42 ); ?>
                                    </a>

                                    <ul class="entry__meta">
                                        <li><a href="<?php echo esc_attr( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php echo esc_html( get_the_author() ) ?></a></li>
                                        <li><?php the_time('M d, Y'); ?></li>
                                    </ul>
                                </div>
                            </div> <!-- end entry__content -->
                            
                        </div> <!-- end entry -->

                <?php 

                    endwhile; 

                endif;

                 wp_reset_postdata(); 
                 
                ?>


            </div> <!-- end featured__small -->

            
        </div> <!-- end featured -->

    </div> <!-- end col-full -->
</div> <!-- end pageheader-content row -->