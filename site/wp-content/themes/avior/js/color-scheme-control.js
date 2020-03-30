/* global avior_colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	var cssTemplate = wp.template( 'avior-color-scheme' ),
		colorSchemeKeys = [
			'background_color',
			'main_text_color',
			'brand_color',
			'brand_color_hover',
			'header_background_color',
            'footer_background_color'
		],
		colorSettings = [
			'background_color',
			'main_text_color',
			'brand_color',
			'brand_color_hover',
			'header_background_color',
            'footer_background_color'
		];

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					var colors = avior_colorScheme[value].colors;

					// Update Background Color.
					var color = colors[0];
					api( 'background_color' ).set( color );
					api.control( 'background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Page Background Color.
					color = colors[1];
					api( 'main_text_color' ).set( color );
					api.control( 'main_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Link Color.
					color = colors[2];
					api( 'brand_color' ).set( color );
					api.control( 'brand_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

					// Update Main Text Color.
					color = colors[3];
					api( 'brand_color_hover' ).set( color );
					api.control( 'brand_color_hover' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );
                    color = colors[4];
                    api( 'header_background_color' ).set( color );
                    api.control( 'header_background_color' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', color )
                        .wpColorPicker( 'defaultColor', color );
                    color = colors[5];
                    api( 'footer_background_color' ).set( color );
                    api.control( 'footer_background_color' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', color )
                        .wpColorPicker( 'defaultColor', color );

				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = 'default',
			css,
			colors = _.object( colorSchemeKeys, avior_colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			colors[ setting ] = api( setting )();
		} );

		// Add additional color.
		// jscs:disable
		colors.border_color = Color( colors.main_text_color ).toCSS( 'rgba', 0.2 );
        colors.site_header_main= Color( colors.header_background_color ).toCSS( 'rgb' );
        colors.site_header_main_rgba= Color( colors.header_background_color ).toCSS( 'rgba', 0.8 );
		// jscs:enable
		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
