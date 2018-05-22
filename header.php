<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package philosophy
 */

$facebookurl = !empty(get_theme_mod( 'philosophy_header_facebook_url_setting' )) ? get_theme_mod( 'philosophy_header_facebook_url_setting' ) : '';
$twitterurl = !empty(get_theme_mod( 'philosophy_header_twitter_url_setting' )) ? get_theme_mod( 'philosophy_header_twitter_url_setting' ) : '';
$instagramurl = !empty(get_theme_mod( 'philosophy_header_instagram_url_setting' )) ? get_theme_mod( 'philosophy_header_instagram_url_setting' ) : '';
$pinteresturl = !empty(get_theme_mod( 'philosophy_header_pinterest_url_setting' )) ? get_theme_mod( 'philosophy_header_pinterest_url_setting' ) : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'philosophy' ); ?></a>

	
    <!-- pageheader
    ================================================== -->
    <section class="s-pageheader s-pageheader--home">

        <header class="header">
            <div class="header__content row">

                <div class="header__logo">
                    <?php 
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    
                    if (has_custom_logo()): ?>
                        <a class="logo" href="<?php echo esc_url( get_site_url() ); ?>">
                            <img src="<?php echo esc_attr( $image[0] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>">
                        </a>
                    <?php else: ?>
                        <a class="logo" href="<?php echo esc_url( get_site_url() ); ?>">
                            <h1><?php echo esc_attr( get_bloginfo( 'title' ) ); ?></h1>
                        </a>

                    <?php endif ?>
                </div> <!-- end header__logo -->

                <?php if( get_theme_mod( 'philosophy_header_social_setting' ) ): ?>
                <ul class="header__social">

                    <?php if ($facebookurl): ?>
                    <li>
                        <a href="<?php echo esc_url( $facebookurl ); ?>"><i class="header-top-facebook fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <?php endif ?>

                   <?php if ($twitterurl): ?>
                    <li>
                        <a href="<?php echo esc_url( $twitterurl ); ?>"><i class="header-top-twitter fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <?php endif ?>

                   <?php if ($instagramurl): ?>
                    <li>
                        <a href="<?php echo esc_url( $instagramurl ); ?>"><i class="header-top-instagram fa fa-instagram" aria-hidden="true"></i></a>
                    </li>
                    <?php endif ?>

                   <?php if ($pinteresturl): ?>
                    <li>
                        <a href="<?php echo esc_url( $pinteresturl ); ?>"><i class="header-top-pinterest fa fa-pinterest" aria-hidden="true"></i></a>
                    </li>
                <?php endif ?>
                </ul> <!-- end header__social -->
                <?php endif; ?>

                <a class="header__search-trigger" href="#0"></a>

                <div class="header__search">
					<form role="search" method="get" class="header__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label>
							<span class="hide-content"><?php esc_html_e( 'Search for:', 'philosophy' ); ?></span>
							<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Type Keywords &hellip;', 'placeholder', 'philosophy' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr( 'Search for:', 'philosophy' ); ?>" autocomplete="off">
						</label>
						<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'philosophy' ); ?>">
					</form>
        
                    <a href="#0" title="Close Search" class="header__overlay-close"><?php esc_html_e( 'Close', 'philosophy' ); ?></a>

                </div>  <!-- end header__search -->


                <a class="header__toggle-menu" href="#0" title="Menu"><span><?php esc_html_e( 'Menu', 'philosophy' ); ?></span></a>

                <nav class="header__nav-wrap">

                    <h2 class="header__nav-heading h6"><?php esc_html_e( 'Site Navigation', 'philosophy' ); ?></h2>
                    <?php 
                    wp_nav_menu( 
                        array( 
                            'theme_location' => 'primary', 
							'menu_class'     => 'header__nav',
							'fallback_cb'    => 'philosophy_bootstrap_navwalker::fallback',
							'walker'    	 => new philosophy_bootstrap_navwalker(),
                        ) );
                    ?>
                    <a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu"><?php esc_html_e( 'Close', 'philosophy' ); ?></a>

                </nav> <!-- end header__nav-wrap -->

            </div> <!-- header-content -->
        </header> <!-- header -->


        <?php 

        if (is_front_page()):

            $my_banner = get_theme_mod( 'banner_posts_setting' ) == 1 ? true : false;

            if ( $my_banner == true ):
            
                get_template_part( 'template-parts/header/header', 'banner' );

            endif;

        endif;

        ?>

    </section> 
        
	<div id="content" class="site-content">
