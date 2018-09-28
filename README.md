## Installation
Helper functions and customizr UI setup have been offloaded to a separate (composer packaged) library 
[sage9-onepager-lib](https://github.com/strarsis/sage9-onepager-lib).

Require the library for the theme (not for the (e.g. Bedrock based) site (`site/`)!),
see [example `composer.json`](https://github.com/strarsis/sage9-onepager-themefiles/blob/master/composer.json#L12).

1. Install the helper library
In the actual sage9-based theme(!) directory:
````
$ composer require strarsis/sage9-onepager-lib
````

2. Require the helper library
In `setup.php`:
```php
// Add onepager controls (to Customizr)
add_action( 'after_setup_theme', '\strarsis\Sage9Onepager\Controls::init' );
````

3. Copy the theme blade files in this repository from [resources/views](https://github.com/strarsis/sage9-onepager-themefiles/tree/master/resources/views) to the theme.

## Further customizations
In `setup.php`:
```php
/**
 * Onepager theme
 */

// Add onepager controls (to Customizr)
add_action( 'after_setup_theme', '\strarsis\Sage9Onepager\Controls::init' );


// ... and for as many page sections as there are currently (published) pages
//     minus one (one is usually the front page above all the others)
add_filter( 'onepager_front_page_sections', '\strarsis\Sage9Onepager\Helpers::default_front_page_sections' );

// ... and for appending the template classes to each panel
add_filter( 'post_class', '\strarsis\Sage9Onepager\Helpers::panel_post_classes' );

// ... and for skipping body classes on front page body
//     because the front page content is added as panel above the other panels
add_filter( 'body_class', '\strarsis\Sage9Onepager\Helpers::panels_front_page_body_class', 100 );


// ... to  exclude all pages on start page from (Yoast) sitemap
add_filter( 'wpseo_sitemap_entry', '\strarsis\Sage9Onepager\Helpers::exclude_included_pages_from_xml_sitemap', 1, 3 );
// ... to  disable Yoast sitemap caching for debugging
//add_filter( 'wpseo_enable_xml_sitemap_transient_caching', '__return_false' );

// ... to  redirect from pages assigned to front page to front page
add_action( 'template_redirect', '\strarsis\Sage9Onepager\Helpers::redirect_included_pages_to_frontpage' );
````
You can also just copy and adjust the code for the filter/action handlers in the [Helpers class](https://github.com/strarsis/sage9-onepager-lib/blob/master/Helpers.php).

## Usage
Pages can be selected in Customizr.
Amount of pages can be modified by using the `onepager_front_page_sections` filter (would be added to `setup.php` of theme), like in the originating Twenty Seventeen theme.

## Filters
### `onepager_front_page_sections(int sections)`
Allows to change the (maximum) amount of page section selection in page panel.

## Useful resources
You can find further useful tips (linking menu items to panels, smooth scrolling) in the README of related [twentyseventeen-onepage modifications repository](https://github.com/strarsis/twentyseventeen-onepage).

## Multilanguage
Support for translation plugins Polylang and WPML has been added.

## Credits
Code has been adopted from [WordPress Twenty Seventeen theme](https://github.com/WordPress/WordPress/tree/master/wp-content/themes/twentyseventeen).

## More than one page with multiple sections?
For more than one page with multiple sections, [Mesh](https://github.com/linchpin/mesh) can be used.

[Gutenberg](https://github.com/WordPress/gutenberg) could also be an option, also [Gutenblock support is planned for Mesh](https://github.com/linchpin/mesh/issues/209).
