<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Avior
 */
?>
</div><!-- #content -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<?php get_sidebar( 'content-bottom' ); ?>
	<div class="wrapper-bottom">
		<div class="wrapper">

			<?php if ( has_nav_menu( 'menu-3' ) ) : ?>
				<nav class="footer-navigation clear" role="navigation"
				     aria-label="<?php esc_attr_e( 'Footer Links Menu', 'avior' ); ?>">
					<?php wp_nav_menu( array(
						'theme_location'  => 'menu-3',
						'menu_id'         => 'footer-navigation',
						'container_class' => 'menu-footer-container',
						'depth'           => 1,
						'link_before'     => '<span class="menu-text">',
						'link_after'      => '</span>'
					) ); ?>
				</nav><!-- .footer-navigation -->
			<?php endif; ?>
			<div class="site-info">
				<?php
				$dateObj = new DateTime;
				$year    = $dateObj->format( "Y" );
				printf( '%2$s &copy; %1$s ', $year, bloginfo( 'name' ) );
				?>
			</div><!-- .site-info -->
		</div><!-- .wrapper -->
	</div><!-- .wrapper-bottom -->
</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>