<?php
/**
 * Template for displaying search forms
 *
 * @package  avior
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-form-wrapper clear">
		<label>
			<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'avior' ); ?></span>
			<input type="search" class="search-field"
			       placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'avior' ); ?>"
			       value="<?php echo get_search_query(); ?>" name="s"/>
		</label>
		<button type="submit" class="search-submit button"><i class="fa fa-search"></i><span
				class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'avior' ); ?></span></button>
	</div>
</form>