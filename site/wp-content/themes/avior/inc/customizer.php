<?php
/**
 * Avior Theme Customizer
 *
 * @package Avior
 */


/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Avior 1.0
 *
 * @see avior_header_style()
 */
function avior_custom_header_and_background()
{
    $color_scheme = avior_get_color_scheme();
    $default_background_color = trim($color_scheme[0], '#');
    $default_text_color = trim($color_scheme[3], '#');
    $default_header_color = trim($color_scheme[6], '#');
    /**
     * Filter the arguments used when adding 'custom-background' support in Avior.
     *
     * @since Avior 1.0
     *
     * @param array $args {
     *     An array of custom-background support arguments.
     *
     * @type string $default -color Default color of the background.
     * }
     */
    add_theme_support('custom-background', apply_filters('avior_custom_background_args', array(
        'default-color' => $default_background_color,
        'wp-head-callback' => 'avior_custom_background_style',
    )));

    /**
     * Filter the arguments used when adding 'custom-header' support in Avior.
     *
     * @since Avior 1.0
     *
     * @param array $args {
     *     An array of custom-header support arguments.
     *
     * @type string $default -text-color Default color of the header text.
     * @type int $width Width in pixels of the custom header image. Default 1200.
     * @type int $height Height in pixels of the custom header image. Default 280.
     * @type bool $flex -height      Whether to allow flexible-height header images. Default true.
     * @type callable $wp -head-callback Callback function used to style the header image and text
     *                                      displayed on the blog.
     * }
     */
    add_theme_support('custom-header', apply_filters('avior_custom_header_args', array(
        'default-text-color' => $default_header_color,
        'width' => 1920,
        'height' => 200,
        'flex-height' => true,
        'wp-head-callback' => 'avior_header_style',
    )));
    add_theme_support('custom-logo', array(
        'height' => 280,
        'width' => 60,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));
}

add_action('after_setup_theme', 'avior_custom_header_and_background');
if (!function_exists('avior_custom_background_style')) :
    /**
     * Styles the custom background displayed on the site.
     *
     * Create your own avior_custom_background_style() function to override in a child theme.
     *
     * @since Avior 1.0
     *
     * @see avior_custom_header_and_background().
     */
    function avior_custom_background_style()
    {
        $background = get_background_color();
        $background_image = get_background_image();
        if (($background != '' && $background != 'ffffff') || $background_image != '') {
            // If the header text has been hidden.
            ?>
            <style type="text/css" id="avior-custom-background-css">
                body.custom-background #page {
                    max-width: 1514px;
                    margin: 0 auto;
                }

                @media screen and (min-width: 62em) {
                    body.custom-background {
                        margin-left: 2.22222em;
                        margin-right: 2.22222em;
                    }
                }

                @media screen and (min-width: 93.375em) {
                    body.custom-background {
                        margin-left: 3.33333em;
                        margin-right: 3.33333em;
                    }
                }
            </style>
            <?php
            _custom_background_cb();
        }
    }
endif; // avior_header_style

if (!function_exists('avior_header_style')) :
    /**
     * Styles the header text displayed on the site.
     *
     * Create your own avior_header_style() function to override in a child theme.
     *
     * @since Avior 1.0
     *
     * @see avior_custom_header_and_background().
     */
    function avior_header_style()
    {
        $header_text_color = get_header_textcolor();


        // If the header text has been hidden.
        ?>
        <style type="text/css" id="avior-header-css">

            .menu-toggle, .main-navigation, .site-header .site-title, .site-header .site-description, .top-navigation-right .theme-social-menu > li > a, .top-navigation-right .nav-menu > li > a, .main-navigation .theme-social-menu > li > a, .main-navigation .nav-menu > li > a {
                color: #<?php echo esc_attr( $header_text_color ); ?>;
            }

            <?php
            // If the header text option is untouched, let's bail.
             if (!display_header_text()) {?>
            .site-branding {
                margin: 0 auto 0 0;
            }

            .site-branding .site-title {
                clip: rect(1px, 1px, 1px, 1px);
                position: absolute;
            }

            <?php }?>
        </style>
        <?php
    }
endif; // avior_header_style

/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @since Avior 1.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function avior_customize_register($wp_customize)
{
    $color_scheme = avior_get_color_scheme();

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector' => '.site-title a',
            'container_inclusive' => false,
            'render_callback' => 'avior_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector' => '.site-description',
            'container_inclusive' => false,
            'render_callback' => 'avior_customize_partial_blogdescription',
        ));
    }
    // Add header background color setting and control.
    $wp_customize->add_setting('header_background_color', array(
        'default' => $color_scheme[4],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_background_color', array(
        'label' => esc_html__('Header background color', 'avior'),
        'section' => 'colors',
    )));
    // Add footer background color setting and control.
    $wp_customize->add_setting('footer_background_color', array(
        'default' => $color_scheme[5],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_background_color', array(
        'label' => esc_html__('Footer background color', 'avior'),
        'section' => 'colors',
    )));
    // Add main text color setting and control.
    $wp_customize->add_setting('main_text_color', array(
        'default' => $color_scheme[1],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_text_color', array(
        'label' => esc_html__('Text Color', 'avior'),
        'section' => 'colors',
    )));

    // Add Brand color setting and control.
    $wp_customize->add_setting('brand_color', array(
        'default' => $color_scheme[2],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'brand_color', array(
        'label' => esc_html__('Link Color', 'avior'),
        'section' => 'colors',
    )));

    // Add Hover Brand color setting and control.
    $wp_customize->add_setting('brand_color_hover', array(
        'default' => $color_scheme[3],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'brand_color_hover', array(
        'label' => esc_html__('Button Hover Color', 'avior'),
        'section' => 'colors',
    )));

}

add_action('customize_register', 'avior_customize_register', 11);

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Avior 1.2
 * @see avior_customize_register()
 *
 * @return void
 */
function avior_customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Avior 1.2
 * @see avior_customize_register()
 *
 * @return void
 */
function avior_customize_partial_blogdescription()
{
    bloginfo('description');
}

/**
 * Registers color schemes for Avior.
 *
 * Can be filtered with {@see 'avior_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Page Background Color.
 * 3. Link Color.
 * 4. Main Text Color.
 * 5. Secondary Text Color.
 *
 * @since Avior 1.0
 *
 * @return array An associative array of color scheme options.
 */
function avior_get_color_schemes()
{
    /**
     * Filter the color schemes registered for use with Avior.
     *
     * The default schemes include 'default', 'dark', 'gray', 'red', and 'yellow'.
     *
     * @since Avior 1.0
     *
     * @param array $schemes {
     *     Associative array of color schemes data.
     *
     * @type array $slug {
     *         Associative array of information for setting up the color scheme.
     *
     * @type string $label Color scheme label.
     * @type array $colors HEX codes for default colors prepended with a hash symbol ('#').
     *                              Colors are defined in the following order: Main background, page
     *                              background, link, main text, secondary text.
     *     }
     * }
     */
    return apply_filters('avior_color_schemes', array(
        'default' => array(
            'label' => esc_html__('Default', 'avior'),
            'colors' => array(
                '#ffffff',
                '#333333',
                '#1ca4d3',
                '#333333',
                '#202b34',
                '#202b34',
                '#fff'
            ),
        )
    ));
}

if (!function_exists('avior_get_color_scheme')) :
    /**
     * Retrieves the current Avior color scheme.
     *
     * Create your own avior_get_color_scheme() function to override in a child theme.
     *
     * @since Avior 1.0
     *
     * @return array An associative array of either the current or default color scheme HEX values.
     */
    function avior_get_color_scheme()
    {
        $color_scheme_option = get_theme_mod('color_scheme', 'default');
        $color_schemes = avior_get_color_schemes();

        if (array_key_exists($color_scheme_option, $color_schemes)) {
            return $color_schemes[$color_scheme_option]['colors'];
        }

        return $color_schemes['default']['colors'];
    }
endif; // avior_get_color_scheme

if (!function_exists('avior_get_color_scheme_choices')) :
    /**
     * Retrieves an array of color scheme choices registered for Avior.
     *
     * Create your own avior_get_color_scheme_choices() function to override
     * in a child theme.
     *
     * @since Avior 1.0
     *
     * @return array Array of color schemes.
     */
    function avior_get_color_scheme_choices()
    {
        $color_schemes = avior_get_color_schemes();
        $color_scheme_control_options = array();

        foreach ($color_schemes as $color_scheme => $value) {
            $color_scheme_control_options[$color_scheme] = $value['label'];
        }

        return $color_scheme_control_options;
    }
endif; // avior_get_color_scheme_choices


if (!function_exists('avior_sanitize_color_scheme')) :
    /**
     * Handles sanitization for Avior color schemes.
     *
     * Create your own avior_sanitize_color_scheme() function to override
     * in a child theme.
     *
     * @since Avior 1.0
     *
     * @param string $value Color scheme name value.
     *
     * @return string Color scheme name.
     */
    function avior_sanitize_color_scheme($value)
    {
        $color_schemes = avior_get_color_scheme_choices();

        if (!array_key_exists($value, $color_schemes)) {
            return 'default';
        }

        return $value;
    }
endif; // avior_sanitize_color_scheme

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Avior 1.0
 *
 * @see wp_add_inline_style()
 */
function avior_color_scheme_css()
{
    $color_scheme_option = get_theme_mod('color_scheme', 'default');

    // Don't do anything if the default color scheme is selected.
    if ('default' === $color_scheme_option) {
        return;
    }

    $color_scheme = avior_get_color_scheme();


    // If we get this far, we have a custom color scheme.
    $colors = array(
        'background_color' => $color_scheme[0],
        'main_text_color' => $color_scheme[1],
        'brand_color' => $color_scheme[2],
        'secondary_text_color' => $color_scheme[3],
        'header_background_color' => $color_scheme[4],
        'footer_background_color' => $color_scheme[5]

    );

    $color_scheme_css = avior_get_color_scheme_css($colors);

    wp_add_inline_style('avior-style', $color_scheme_css);
}

add_action('wp_enqueue_scripts', 'avior_color_scheme_css');


/**
 * Returns CSS for the color schemes.
 *
 * @since Avior 1.0
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function avior_get_color_scheme_css($colors)
{
    $colors = wp_parse_args($colors, array(
        'background_color' => '',
        'main_text_color' => '',
        'brand_color' => '',
        'brand_color_hover' => '',
        'header_background_color' => '',
        'footer_background_color' => '',
        'site_header_main' => '',
        'site_header_main_rgba' => '',
        'header_textcolor' => ''
    ));
    return <<<CSS
	/* Color Scheme */

	/* Background Color */
	body {
		background-color: {$colors['background_color']};
	}
	/* Brand Color */
	select:focus, input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, input[type="range"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="time"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="color"]:focus, textarea:focus,
	.tagcloud a:hover,
	button, .button, input[type="button"], input[type="reset"], input[type="submit"] {
	  border-color:  {$colors['brand_color']};
	}
	.top-navigation-right .menu-item-has-children .dropdown-toggle:hover,
	.pagination a.prev:hover, .pagination a.next:hover,
	.pagination a.prev:focus, .pagination a.next:focus,
	button, .button, input[type="button"], input[type="reset"], input[type="submit"]{
	  background-color: {$colors['brand_color']};
	}
	 .top-navigation-right .current_page_item > a, .top-navigation-right .current-menu-item > a, .top-navigation-right .current_page_ancestor > a, .top-navigation-right .current-menu-ancestor > a, .main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a, .main-navigation .current-menu-ancestor > a,
	.post-navigation a:hover,
	.search-modal .close-search-modal:hover, .search-icon-wrapper:hover,
	.widget.widget_calendar tbody a,
	.search-icon-wrapper a:hover,
	.tagcloud a:hover,
	.entry-footer a:hover, .entry-meta a:hover, .entry-title a:hover, .entry-title a:focus,
    .top-navigation-right li:hover > a, 
	a {
	  color:  {$colors['brand_color']};
	}
	@media screen and (min-width: 62em){
	.main-navigation li:hover > a{
	  color:  {$colors['brand_color']};
	}
	}
	/* Brand Color  Hover*/	

	.sticky-post,.pagination a.prev, .pagination a.next,
	button:hover,button:focus,
	.button:hover,.button:focus,
	input[type="button"]:hover,input[type="button"]:focus,
	input[type="reset"]:hover,input[type="reset"]:focus,
	input[type="submit"]:hover,input[type="submit"]:focus {
	  background-color:  {$colors['brand_color_hover']};
	  border-color:  {$colors['brand_color_hover']};
	}	
	/* Main Text Color */
	body {
	  color: {$colors['main_text_color']};
	}
	mark, ins {
	  background: {$colors['main_text_color']};
	}
	/* Footer Background Color */
    .site-footer{
      background-color:  {$colors['footer_background_color']};
    }
    /* Header Background Color */
	.site-header {
      background-color:  {$colors['header_background_color']};
    }
    .site-header-main{
        background-color:{$colors['site_header_main']};
    }
    @media screen and (min-width: 62em){
        .site-header-main{
            background-color: {$colors['site_header_main_rgba']};
        }
    }
	a:focus {
        outline-color: {$colors['main_text_color']};
    }	

    body.woocommerce-cart table.cart .coupon .button:hover, body .woocommerce-cart table.cart .coupon .button:focus,
    body .woocommerce-cart table.cart .coupon .button:hover, body.woocommerce-cart table.cart .coupon .button:focus,
    body.woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover,
    body .woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover,
    body.woocommerce #respond input#submit.alt, body .woocommerce a.button.alt, body.woocommerce button.button.alt, body.woocommerce input.button.alt,
    body .woocommerce #respond input#submit.alt, body.woocommerce a.button.alt, body .woocommerce button.button.alt, body.woocommerce input.button.alt,
    body .widget .woocommerce-product-search:before,
    body.woocommerce nav.woocommerce-pagination ul li a.prev:hover, body.woocommerce nav.woocommerce-pagination ul li a.prev:focus, body.woocommerce nav.woocommerce-pagination ul li a.next:hover, body.woocommerce nav.woocommerce-pagination ul li a.next:focus,
    body .woocommerce nav.woocommerce-pagination ul li a.prev:hover, body .woocommerce nav.woocommerce-pagination ul li a.prev:focus, body .woocommerce nav.woocommerce-pagination ul li a.next:hover, body .woocommerce nav.woocommerce-pagination ul li a.next:focus,
    body.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
    body .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
    body.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
    body .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
    body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button,
    body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button{
        background-color: {$colors['brand_color']};
    }
    body .woocommerce-error, body .woocommerce-info, body .woocommerce-message,           
    body.woocommerce-cart table.cart .coupon .button:hover, body .woocommerce-cart table.cart .coupon .button:focus,
    body .woocommerce-cart table.cart .coupon .button:hover, body.woocommerce-cart table.cart .coupon .button:focus,
    body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button,
    body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button,
    body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
    body .woocommerce div.product .woocommerce-tabs ul.tabs li.active a{
         border-color: {$colors['brand_color']};
    }
    body.woocommerce p.stars.selected a.active::before, body.woocommerce p.stars.selected a:not(.active)::before, body.woocommerce p.stars:hover a::before, body.woocommerce p.stars a:hover::before,
    body .woocommerce p.stars.selected a.active::before, body .woocommerce p.stars.selected a:not(.active)::before, body .woocommerce p.stars:hover a::before, body .woocommerce p.stars a:hover::before,
    body.woocommerce div.product .woocommerce-tabs ul.tabs li a,
    body .woocommerce div.product .woocommerce-tabs ul.tabs li a,
    body.woocommerce ul.products li.product .woocommerce-loop-product__link:hover,
    body .woocommerce ul.products li.product .woocommerce-loop-product__link:hover,
    body .site-header-cart .cart-contents:hover,
    body.woocommerce .woocommerce-breadcrumb a, body.woocommerce-page .woocommerce-breadcrumb a,
    body .woocommerce .woocommerce-breadcrumb a, body .woocommerce-page .woocommerce-breadcrumb a,
    body .woocommerce .star-rating span::before,
    body.woocommerce .star-rating span::before{
         color: {$colors['brand_color']};
    }
    body.woocommerce a.remove:hover,
    body .woocommerce a.remove:hover{
         color: {$colors['brand_color']};!important;
    }
    body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
    body .woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
    body.woocommerce div.product .woocommerce-grouped-product-list-item__price, body.woocommerce div.product .woocommerce-variation-price .price, body.woocommerce div.product p.price,
    body .woocommerce div.product .woocommerce-grouped-product-list-item__price, body .woocommerce div.product .woocommerce-variation-price .price, body .woocommerce div.product p.price,
    body.woocommerce ul.products li.product .price,
    body.woocommerce nav.woocommerce-pagination ul li span.current,
    body .woocommerce nav.woocommerce-pagination ul li span.current,
    body .woocommerce ul.products li.product .price,
    body.woocommerce ul.product_list_widget .woocommerce-Price-amount,
    body .woocommerce ul.product_list_widget .woocommerce-Price-amount{
	     color: {$colors['main_text_color']};
    }
    body.woocommerce-cart table.cart .coupon .button,
    body .woocommerce-cart table.cart .coupon .button,
    body.woocommerce #respond input#submit.alt:hover, body.woocommerce a.button.alt:hover, body.woocommerce button.button.alt:hover, body.woocommerce input.button.alt:hover,
    body .woocommerce #respond input#submit.alt:hover, body .woocommerce a.button.alt:hover, body .woocommerce button.button.alt:hover, body .woocommerce input.button.alt:hover,
    body.woocommerce nav.woocommerce-pagination ul li a.prev, body.woocommerce nav.woocommerce-pagination ul li a.next,
    body .woocommerce nav.woocommerce-pagination ul li a.prev, body .woocommerce nav.woocommerce-pagination ul li a.next
    body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover,
    body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover{
        background-color:{$colors['brand_color_hover']};
    }
    body.woocommerce-cart table.cart .coupon .button,
    body .woocommerce-cart table.cart .coupon .button,
    body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover,
    body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover{
        border-color:{$colors['brand_color_hover']};
    }
CSS;
}


/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since Avior 1.0
 */
function avior_color_scheme_css_template()
{
    $colors = array(
        'background_color' => '{{ data.background_color }}',
        'main_text_color' => '{{ data.main_text_color }}',
        'brand_color' => '{{ data.brand_color }}',
        'brand_color_hover' => '{{ data.brand_color_hover }}',
        'header_background_color' => '{{data.header_background_color}}',
        'footer_background_color' => '{{data.footer_background_color}}',
        'site_header_main' => '{{data.site_header_main}}',
        'site_header_main_rgba' => '{{data.site_header_main_rgba}}',
        'header_textcolor' => '{{data.header_textcolor}}'
    );
    ?>
    <script type="text/html" id="tmpl-avior-color-scheme">
        <?php echo avior_get_color_scheme_css($colors); ?>
    </script>
    <?php
}

add_action('customize_controls_print_footer_scripts', 'avior_color_scheme_css_template');


/**
 * Enqueues front-end CSS for the footer background color.
 *
 * @since Avior 1.0
 *
 * @see wp_add_inline_style()
 */
function avior_footer_background_color_css()
{
    $color_scheme = avior_get_color_scheme();
    $default_color = $color_scheme[5];
    $footer_background_color = get_theme_mod('footer_background_color', $default_color);
    // Don't do anything if the current color is the default.
    if ($footer_background_color === $default_color) {
        return;
    }
    $css = '
    .site-footer {
     background-color: %1$s;
    }
    
	';

    wp_add_inline_style('avior-style', sprintf($css, esc_html($footer_background_color)));
}

add_action('wp_enqueue_scripts', 'avior_footer_background_color_css', 11);
/**
 * Enqueues front-end CSS for the header background color.
 *
 * @since Avior 1.0
 *
 * @see wp_add_inline_style()
 */
function avior_header_background_color_css()
{
    $color_scheme = avior_get_color_scheme();
    $default_color = $color_scheme[4];
    $header_background_color = get_theme_mod('header_background_color', $default_color);
    $header_background_color_rgb = avior_hex2rgb($header_background_color);
    $site_header_main = vsprintf('rgba( %1$s, %2$s, %3$s, 0.8)', $header_background_color_rgb);
    // Don't do anything if the current color is the default.
    if ($header_background_color === $default_color) {
        return;
    }
    $css = '
	.site-header {
     background-color: %1$s;
    }
    .site-header-main{
        background-color: %2$s;
    }
    @media screen and (min-width: 62em){
        .site-header-main{
            background-color: %3$s;
        }
    }
	';

    wp_add_inline_style('avior-style', sprintf($css, esc_html($header_background_color), esc_html($header_background_color), esc_html($site_header_main)));
}

add_action('wp_enqueue_scripts', 'avior_header_background_color_css', 11);
/**
 * Enqueues front-end CSS for the link color.
 *
 * @since Avior 1.0
 *
 * @see wp_add_inline_style()
 */
function avior_brand_color_css()
{
    $color_scheme = avior_get_color_scheme();
    $default_color = $color_scheme[2];
    $brand_color = get_theme_mod('brand_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($brand_color === $default_color) {
        return;
    }

    $css = '
	.tagcloud a:hover,
	button, .button, input[type="button"], input[type="reset"], input[type="submit"],
	blockquote {
	  border-color: %1$s;
	}
	.top-navigation-right .menu-item-has-children .dropdown-toggle:hover,
	.pagination a.prev:hover, .pagination a.next:hover,
	.pagination a.prev:focus, .pagination a.next:focus,
	button, .button, input[type="button"], input[type="reset"], input[type="submit"]{
	  background-color: %1$s;
	}
	.top-navigation-right .current_page_item > a, .top-navigation-right .current-menu-item > a, .top-navigation-right .current_page_ancestor > a, .top-navigation-right .current-menu-ancestor > a, .main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a, .main-navigation .current-menu-ancestor > a,
	.post-navigation a:hover,
	.search-modal .close-search-modal:hover, .search-icon-wrapper:hover,
	.widget.widget_calendar tbody a,
	.search-icon-wrapper a:hover,
	.tagcloud a:hover,
	.entry-footer a:hover, .entry-meta a:hover, .entry-title a:hover, .entry-title a:focus,
	.top-navigation-right li:hover > a, 
	a {
	  color: %1$s;
	}
	@media screen and (min-width: 62em){
        .main-navigation li:hover > a{
          color: %1$s;
        }
	}
	';
    if (class_exists('WooCommerce')) {
        $css .= '
           body.woocommerce-cart table.cart .coupon .button:hover, body .woocommerce-cart table.cart .coupon .button:focus,
           body .woocommerce-cart table.cart .coupon .button:hover, body.woocommerce-cart table.cart .coupon .button:focus,
           body.woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover,
           body .woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover,
           body.woocommerce #respond input#submit.alt, body .woocommerce a.button.alt, body.woocommerce button.button.alt, body.woocommerce input.button.alt,
           body .woocommerce #respond input#submit.alt, body.woocommerce a.button.alt, body .woocommerce button.button.alt, body.woocommerce input.button.alt,
           body .widget .woocommerce-product-search:before,
           body.woocommerce nav.woocommerce-pagination ul li a.prev:hover, body.woocommerce nav.woocommerce-pagination ul li a.prev:focus, body.woocommerce nav.woocommerce-pagination ul li a.next:hover, body.woocommerce nav.woocommerce-pagination ul li a.next:focus,
           body .woocommerce nav.woocommerce-pagination ul li a.prev:hover, body .woocommerce nav.woocommerce-pagination ul li a.prev:focus, body .woocommerce nav.woocommerce-pagination ul li a.next:hover, body .woocommerce nav.woocommerce-pagination ul li a.next:focus,
           body.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
           body .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
           body.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
           body .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
           body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button,
           body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button{
                background-color: %1$s;
           }
           body .woocommerce-error, body .woocommerce-info, body .woocommerce-message,           
           body.woocommerce-cart table.cart .coupon .button:hover, body .woocommerce-cart table.cart .coupon .button:focus,
           body .woocommerce-cart table.cart .coupon .button:hover, body.woocommerce-cart table.cart .coupon .button:focus,
           body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button,
           body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button,
           body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
           body .woocommerce div.product .woocommerce-tabs ul.tabs li.active a{
                border-color: %1$s;
           }
           body.woocommerce p.stars.selected a.active::before, body.woocommerce p.stars.selected a:not(.active)::before, body.woocommerce p.stars:hover a::before, body.woocommerce p.stars a:hover::before,
           body .woocommerce p.stars.selected a.active::before, body .woocommerce p.stars.selected a:not(.active)::before, body .woocommerce p.stars:hover a::before, body .woocommerce p.stars a:hover::before,
           body.woocommerce div.product .woocommerce-tabs ul.tabs li a,
           body .woocommerce div.product .woocommerce-tabs ul.tabs li a,
           body.woocommerce ul.products li.product .woocommerce-loop-product__link:hover,
           body .woocommerce ul.products li.product .woocommerce-loop-product__link:hover,
           body .site-header-cart .cart-contents:hover,
           body.woocommerce .woocommerce-breadcrumb a, body.woocommerce-page .woocommerce-breadcrumb a,
           body .woocommerce .woocommerce-breadcrumb a, body .woocommerce-page .woocommerce-breadcrumb a,
           body .woocommerce .star-rating span::before,
           body.woocommerce .star-rating span::before{
                color: %1$s;
           }
           body.woocommerce a.remove:hover,
           body .woocommerce a.remove:hover{
                color: %1$s!important;
           }
           
        ';
    }
    wp_add_inline_style('avior-style', sprintf($css, esc_html($brand_color)));
}

add_action('wp_enqueue_scripts', 'avior_brand_color_css', 11);

/**
 * Enqueues front-end CSS for the main text color.
 *
 * @since Avior 1.0
 *
 * @see wp_add_inline_style()
 */
function avior_main_text_color_css()
{
    $color_scheme = avior_get_color_scheme();
    $default_color = $color_scheme[1];
    $main_text_color = get_theme_mod('main_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($main_text_color === $default_color) {
        return;
    }

    $css = '
		/* Custom Main Text Color */
		body {
	        color: %1$s;
		}
		mark, ins {
		     background: %1$s;
		}
	';
    if (class_exists('WooCommerce')) {
        $css .= '
           body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
           body .woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
           body.woocommerce div.product .woocommerce-grouped-product-list-item__price, body.woocommerce div.product .woocommerce-variation-price .price, body.woocommerce div.product p.price,
           body .woocommerce div.product .woocommerce-grouped-product-list-item__price, body .woocommerce div.product .woocommerce-variation-price .price, body .woocommerce div.product p.price,
           body.woocommerce ul.products li.product .price,
           body.woocommerce nav.woocommerce-pagination ul li span.current,
           body .woocommerce nav.woocommerce-pagination ul li span.current,
           body .woocommerce ul.products li.product .price,
           body.woocommerce ul.product_list_widget .woocommerce-Price-amount,
           body .woocommerce ul.product_list_widget .woocommerce-Price-amount{
	        color: %1$s;
           }
        ';
    }
    wp_add_inline_style('avior-style', sprintf($css, esc_html($main_text_color)));
}

add_action('wp_enqueue_scripts', 'avior_main_text_color_css', 11);


/**
 * Enqueues front-end CSS for the link color.
 *
 * @since Avior 1.0
 *
 * @see wp_add_inline_style()
 */
function avior_brand_color_hover_css()
{
    $color_scheme = avior_get_color_scheme();
    $default_color = $color_scheme[3];
    $brand_color_hover = get_theme_mod('brand_color_hover', $default_color);

    // Don't do anything if the current color is the default.
    if ($brand_color_hover === $default_color) {
        return;
    }

    $css = '
	.sticky-post,.pagination a.prev, .pagination a.next,
	button:hover,button:focus,
	.button:hover,.button:focus,
	input[type="button"]:hover,input[type="button"]:focus,
	input[type="reset"]:hover,input[type="reset"]:focus,
	input[type="submit"]:hover,input[type="submit"]:focus {
	  background-color:  %1$s;
	  border-color:  %1$s;
	}	
	';
    if (class_exists('WooCommerce')) {
        $css .= '
           body.woocommerce-cart table.cart .coupon .button,
           body .woocommerce-cart table.cart .coupon .button,
           body.woocommerce #respond input#submit.alt:hover, body.woocommerce a.button.alt:hover, body.woocommerce button.button.alt:hover, body.woocommerce input.button.alt:hover,
           body .woocommerce #respond input#submit.alt:hover, body .woocommerce a.button.alt:hover, body .woocommerce button.button.alt:hover, body .woocommerce input.button.alt:hover,
           body.woocommerce nav.woocommerce-pagination ul li a.prev, body.woocommerce nav.woocommerce-pagination ul li a.next,
           body .woocommerce nav.woocommerce-pagination ul li a.prev, body .woocommerce nav.woocommerce-pagination ul li a.next
           body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover,
           body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover{
                background-color: %1$s;
           }
           body.woocommerce-cart table.cart .coupon .button,
           body .woocommerce-cart table.cart .coupon .button,
           body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover,
           body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover{
                border-color: %1$s;
           }
        ';
    }
    wp_add_inline_style('avior-style', sprintf($css, esc_html($brand_color_hover)));
}

add_action('wp_enqueue_scripts', 'avior_brand_color_hover_css', 11);


/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as avior_colorScheme global.
 *
 */
function avior_customize_control_js()
{
    wp_enqueue_script('avior-color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array(
        'customize-controls',
        'iris',
        'underscore',
        'wp-util'
    ), '20160816', true);
    wp_localize_script('avior-color-scheme-control', 'avior_colorScheme', avior_get_color_schemes());
}

add_action('customize_controls_enqueue_scripts', 'avior_customize_control_js');

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 */
function avior_customize_preview_js()
{
    wp_enqueue_script('avior-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array('customize-preview'), '20160816', true);
}

add_action('customize_preview_init', 'avior_customize_preview_js');

/**
 * Convert HEX to RGB.
 *
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function avior_hex2rgb($color)
{
    $color = trim($color, '#');

    if (strlen($color) == 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else if (strlen($color) == 6) {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    } else {
        return array();
    }

    return array('red' => $r, 'green' => $g, 'blue' => $b);
}