<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Avior
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
	<?php avior_post_thumbnail(); ?>
	<div class="entry-row">
		<?php avior_entry_meta(); ?>
		<div class="entry-wrapper">
			<header class="entry-header">
				<?php if ( is_sticky() ) : ?>
					<div class="sticky-post-wrapper">
						<span class="sticky-post"><?php esc_html_e( 'Featured', 'avior' ); ?></span>
					</div>
				<?php endif;
				$avior_icon = ( get_post_format() === 'link' ) ? '<i class="fa fa-link" aria-hidden="true"></i> ' : '';
				?>
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $avior_icon, '</a></h2>' ); ?>
			</header><!-- .entry-header -->
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
		</div><!-- .entry-wrapper -->
	</div><!-- .entry-row -->
</article><!-- #post-## -->