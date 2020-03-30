<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Avior
 */

get_header(); ?>
	<div class="wrapper main-wrapper clear">
		<div id="primary" class="content-area ">
			<main id="main" class="site-main" role="main">
				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'avior' ); ?></h1>
					</header><!-- .page-header -->
					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'avior' ); ?></p>
						<div class="form-search-wrapper">
							<?php get_search_form(); ?>
						</div><!-- .form-search-wrapper -->
					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>
	</div><!-- .wrapper -->
<?php get_footer();
