<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Avior
 */

get_header(); ?>
	<div class="wrapper main-wrapper clear">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php if ( have_posts() ) : ?>
					<header class="page-header">
						<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						?>
					</header><!-- .page-header -->
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;
					// Previous/next page navigation.
					avior_the_posts_pagination();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif; ?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>
	</div><!-- .main-wrapper -->
<?php get_footer();