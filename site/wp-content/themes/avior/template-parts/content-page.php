<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Avior
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (function_exists('is_cart') && function_exists('is_checkout')) {
        if (is_cart() || is_checkout()) {
            do_action('avior_woocommerce_breadcrumb');
        }
    }?>
	<header class="entry-header">
		<?php if ( is_sticky() ) : ?>
			<div class="sticky-post-wrapper">
				<span class="sticky-post"><?php esc_html_e( 'Featured', 'avior' ); ?></span>
			</div>
		<?php endif;
		$avior_icon = ( get_post_format() === 'link' ) ? '<i class="fa fa-link" aria-hidden="true"></i> ' : '';
		?>
		<?php the_title( '<h1 class="entry-title">' . $avior_icon, '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php avior_post_thumbnail(); ?>
	<div class="entry-content">
		<?php the_content( sprintf(
		/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'avior' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'avior' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
	<?php // If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
	?>
</article><!-- #post-## -->
