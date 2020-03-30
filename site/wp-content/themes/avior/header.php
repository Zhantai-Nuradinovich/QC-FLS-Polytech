<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Avior
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open();?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'avior'); ?></a>
    <header id="masthead" class="site-header" role="banner" <?php avior_header_image(); ?>>
        <div class="site-header-main <?php if (!has_nav_menu('menu-1')) : echo 'no-menu'; endif; ?>">
            <div class="wrapper">
                <div class="site-branding">
                    <div class="site-logo-wrapper" itemscope>
                        <div>
                            <?php avior_the_custom_logo(); ?>
                            <div class="site-title-wrapper">
                                <?php if (is_front_page() && is_home()) : ?>
                                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                              rel="home"><?php bloginfo('name'); ?></a></h1>
                                <?php else : ?>
                                    <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                             rel="home"><?php bloginfo('name'); ?></a></p>
                                    <?php
                                endif;
                                $description = apply_filters('avior_tagline', get_bloginfo('description', 'display'));
                                if ($description || is_customize_preview()) : ?>
                                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                                    <?php
                                endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if (has_nav_menu('menu-2')) : ?>
                        <nav class="top-navigation-right clear" role="navigation"
                             aria-label="<?php esc_attr_e('Top Links Menu', 'avior'); ?>"><?php if (has_nav_menu('menu-2')) : ?>
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'menu-2',
                                    'menu_id' => 'top-navigation',
                                    'menu_class' => 'theme-social-menu menu',
                                    'container_class' => 'menu-top-right-container clear',
                                    'link_before' => '<span class="menu-text">',
                                    'link_after' => '</span>'
                                )); ?>
                            <?php endif; ?>
                        </nav>
                    <?php endif; ?>
                </div><!-- .site-branding -->
            </div><!-- .wrapper -->
            <div class="bottom-site-header">
                <div class="wrapper">
                    <div class="site-header-menu "
                         id="site-header-menu">
                        <div class="menu-toggle-wrapper clear">
                            <?php if (has_nav_menu('menu-1') || has_nav_menu('menu-2')) : ?>
                                <button class="menu-toggle" aria-controls="primary-menu"
                                        aria-expanded="false"><i class="fa fa-bars" aria-hidden="true"></i>
                                    <span><?php esc_html_e('Menu', 'avior'); ?></span><span><?php esc_html_e('Close', 'avior'); ?></span>
                                </button>
                            <?php endif; ?>
                        </div> <!--- .menu-toggle-wrapper -->
                        <nav id="site-navigation" class="main-navigation" role="navigation">
                            <?php if (has_nav_menu('menu-1')) : ?>
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'menu-1',
                                    'container_class' => 'menu-primary-container clear',
                                    'menu_id' => 'primary-menu',
                                    'menu_class' => 'menu nav-menu',
                                    'link_before' => '<span class="menu-text">',
                                    'link_after' => '</span>'
                                )); ?>
                            <?php endif; ?>
                            <?php if (has_nav_menu('menu-2')) : ?>
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'menu-2',
                                    'menu_id' => 'top-navigation-mobile',
                                    'menu_class' => 'top-navigation-mobile theme-social-menu',
                                    'container_class' => 'menu-top-right-container clear',
                                    'link_before' => '<span class="menu-text">',
                                    'link_after' => '</span>'
                                )); ?>
                            <?php endif; ?>
                        </nav><!-- #site-navigation -->
                        <?php do_action('avior_header');?>
                    </div>
                </div><!-- .wrapper -->
            </div><!--- .bottom-site-header--->
        </div><!-- .site-header-main -->

    </header><!-- #masthead -->
    <div id="content" class="site-content ">
