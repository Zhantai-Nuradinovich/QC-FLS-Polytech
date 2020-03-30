<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Avior
 */

if (!function_exists('avior_get_posted_on_by')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function avior_get_posted_on_by()
    {
        global $post;
        $string = '';
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }
        $time_string = sprintf($time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        $posted_on = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>';


        $byline = sprintf(
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">'
            . esc_html(get_the_author()) . '</a></span>'
        );

        $string = '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

        return $string;
    }
endif;


if (!function_exists('avior_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time, author, categories.
     */
    function avior_posted_on($short = false)
    {
        global $post;
        ?>
        <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
           rel="author">
            <div class="author-avatar">
                <?php
                /**
                 * Filter the avior author bio avatar size.
                 */
                $author_bio_avatar_size = apply_filters('avior_author_avatar_size', 64);
                echo get_avatar(get_the_author_meta('user_email'), $author_bio_avatar_size); ?>
            </div><!-- .author-avatar -->
        </a><!-- .author-link-->
        <?php
        $posted_on_by = apply_filters('avior_get_posted_on_by', avior_get_posted_on_by());
        if ($posted_on_by != '') {
            echo $posted_on_by;
        }
        if (!$short) {
            if (!post_password_required() && (comments_open() || get_comments_number())) {
                $id = get_the_ID();
                $number = get_comments_number($id);
                $more = wp_kses(_n('%1$s Comment<span class="screen-reader-text"> on %2$s</span>', '%1$s Comments<span class="screen-reader-text"> on %2$s</span>', $number, 'avior'), array('span' => array('class' => array())));
                $title = get_the_title();
                echo '<span class="comments-link">';
                comments_popup_link(sprintf(wp_kses(__('Leave a comment<span class="screen-reader-text"> on %s</span>', 'avior'), array('span' => array('class' => array()))), $title),
                    sprintf(wp_kses(__('1 Comment<span class="screen-reader-text"> on %s</span>', 'avior'), array('span' => array('class' => array()))), $title),
                    sprintf($more, number_format_i18n($number), $title));
                echo '</span>';
            }
            if ('post' === get_post_type()) {
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list(' ');
                if ($categories_list && avior_categorized_blog()) {
                    printf('<span class="cat-links">%1$s</span>', $categories_list); // WPCS: XSS OK.
                }

            }
        }

    }
endif;
if (!function_exists('avior_entry_meta')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function avior_entry_meta()
    { ?>
        <div class="entry-meta">
            <?php

            if ('post' === get_post_type()) {
                avior_posted_on();
            }
            edit_post_link(
                sprintf(
                /* translators: %s: Name of current post */
                    esc_html__('Edit %1$s', 'avior'),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </div><!-- .entry-footer -->
        <?php
    }
endif;

if (!function_exists('avior_the_tags')) :
    /**
     * Displays post tags.
     */
    function avior_the_tags()
    {
        if ('post' === get_post_type()) {
            $tags_list = get_the_tag_list('', esc_html_x(' ', 'Used between list items, there is a space.', 'avior'));
            if ($tags_list) {
                printf('<p class="tagcloud"><span class="tags-links"><span class="tags-title">%1$s </span><span class="screen-reader-text">%2$s </span>%3$s</span></p>',
                    esc_html__('Tagged: ', 'avior'),
                    esc_html_x('Tags', 'Used before tag names.', 'avior'),
                    $tags_list
                );
            }
        }
    }
endif;

if (!function_exists('avior_entry_footer')) :
    /**
     * Prints HTML with meta information.
     */
    function avior_entry_footer()
    { ?>
        <div class="entry-footer">
            <?php
            avior_posted_on(true);
            edit_post_link(
                sprintf(
                /* translators: %s: Name of current post */
                    esc_html__('Edit %1$s', 'avior'),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </div><!-- .entry-footer -->
        <?php
    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function avior_categorized_blog()
{
    if (false === ($all_the_cool_cats = get_transient('avior_categories'))) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('avior_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so avior_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so avior_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in avior_categorized_blog.
 */
function avior_category_transient_flusher()
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('avior_categories');
}

add_action('edit_category', 'avior_category_transient_flusher');
add_action('save_post', 'avior_category_transient_flusher');


if (!function_exists('avior_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function avior_post_thumbnail()
    {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }
        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('avior-thumb-large'); ?>
            </div><!-- .post-thumbnail -->
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
                <?php the_post_thumbnail('post-thumbnail'); ?>
            </a><!-- .post-thumbnail -->
        <?php endif; // End is_singular()
    }
endif;
if (!function_exists('avior_home_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function avior_home_thumbnail()
    {
        get_sidebar('frontpage');
    }
endif;

if (!function_exists('avior_the_post_navigation')) :
    /**
     * Displays the post navigation.
     */
    function avior_the_post_navigation()
    {
        the_post_navigation(array(
            'next_text' => '<div class="nav-bg"><div><span class="meta-nav" aria-hidden="true">' . esc_html__('next', 'avior') . '</span> ' .
                '<span class="screen-reader-text">' . esc_html__('Next post:', 'avior') . '</span> ' .
                '<span class="post-title">%title</span></div></div>',
            'prev_text' => '<div class="nav-bg"><div><span class="meta-nav" aria-hidden="true">' . esc_html__('previous', 'avior') . '</span> ' .
                '<span class="screen-reader-text">' . esc_html__('Previous post:', 'avior') . '</span> ' .
                '<span class="post-title">%title</span></div></div>'
        ));

    }
endif;

if (!function_exists('avior_the_posts_pagination')) :
    /**
     * Displays the post pagination.
     */
    function avior_the_posts_pagination()
    {
        the_posts_pagination(array(
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'avior') . ' </span>',
            'mid_size' => 2,
        ));
    }
endif;

if (!function_exists('avior_excerpt')) :
    /**
     * Displays the optional excerpt.
     *
     * Wraps the excerpt in a div element.
     *
     * Create your own avior_excerpt() function to override in a child theme.
     *
     * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
     */
    function avior_excerpt($class = 'entry-summary')
    {
        $class = esc_attr($class);
        $excerpt = get_the_excerpt();
        if (!empty($excerpt)) { ?>
            <div class="<?php echo $class; ?>">
                <?php echo $excerpt; ?>
            </div><!-- .<?php echo $class; ?> -->
        <?php }
    }
endif;

if (!function_exists('avior_excerpt_more')) :
    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ... and
     * a 'Continue reading' link.
     *
     * Create your own avior_excerpt_more() function to override in a child theme.
     *
     *
     * @return string 'Continue reading' link prepended with an ellipsis.
     */
    function avior_excerpt_more()
    {
        $link = sprintf('<a href="%1$s" class="more-link">%2$s</a>',
            esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */
            sprintf(wp_kses(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'avior'), array('span' => array('class' => array()))), get_the_title(get_the_ID()))
        );

        return ' &hellip; ' . $link;
    }

endif;

add_filter('excerpt_more', 'avior_excerpt_more');
if (!function_exists('avior_read_more')) :
    /**
     * Create your own avior_read_more() function to override in a child theme.
     */
    function avior_read_more($more_link, $more_link_text)
    {

        return '<p>' . $more_link . '</p>';
    }

endif;

if (!function_exists('avior_related_posts')) :
    /**
     * Displays related posts
     */
    function avior_related_posts($post)
    {
        if ('post' === get_post_type()) {

            global $post;
            $tags = wp_get_post_tags($post->ID);
            if ($tags) {
                $tag_ids = array();
                foreach ($tags as $individual_tag) {
                    $tag_ids[] = $individual_tag->term_id;
                }
                $args = array(
                    'tag__in' => $tag_ids,
                    'post__not_in' => array($post->ID),
                    'posts_per_page' => 4
                );
                $my_query = new wp_query($args);
                if ($my_query->have_posts()):
                    ?>
                    <div class="related-posts">
                        <h2 class="related-posts-title"><?php esc_html_e('Related Posts', 'avior'); ?></h2>
                        <!-- .related-posts-title -->
                        <ul>
                            <?php
                            while ($my_query->have_posts()) {
                                $my_query->the_post();
                                ?>
                                <li>
                                    <a href="<?php the_permalink() ?>" rel="bookmark"
                                       title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div><!-- .related-posts -->
                    <?php
                endif;
                ?>
                <?php
            }

            wp_reset_query();
        }
    }

endif;
if (!function_exists('avior_header_image')) :

    /**
     * Displays header image. Echo background image style.
     */
    function avior_header_image()
    {
        if (has_header_image()) {
            echo 'style="background-image: url(' . get_header_image() . ')"';
        }
    }


endif;

if ( ! function_exists( 'wp_body_open' ) ) :
    function wp_body_open() {
        do_action( 'wp_body_open' );
}
endif;