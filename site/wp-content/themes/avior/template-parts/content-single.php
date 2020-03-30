<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Avior
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
	<div class="entry-row">
		<?php avior_entry_meta(); ?>
		<div class="entry-wrapper">
			<div class="entry-content">
				<?php the_content( sprintf(
				/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s', 'avior' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				avior_the_tags();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'avior' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->
			<?php avior_related_posts( $post ); ?>
			<?php if ( is_single() && get_the_author_meta( 'description' ) && 'post' === get_post_type() ) :
				get_template_part( 'template-parts/biography' );
			endif;
			?>
		</div><!-- .entry-wrapper -->
	</div><!-- .entry-row -->
</article><!-- #post-## -->