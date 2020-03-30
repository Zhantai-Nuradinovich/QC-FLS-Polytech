<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Avior
 */

get_header(); ?>
<?php if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
		<div class="wrapper main-wrapper clear">
			<div id="primary" class="content-area ">
				<main id="main" class="site-main" role="main">
					<?php get_template_part( 'template-parts/content', 'single' );
					avior_the_post_navigation();
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div><!-- .wrapper -->
		<?php
	endwhile; // End of the loop.
else:?>
	<div class="wrapper main-wrapper clear">
		<div id="primary" class="content-area ">
			<main id="main" class="site-main" role="main">
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>
	</div><!-- .wrapper -->
<?php endif;
get_footer();