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
/**
 * Add onepager controls (to Customizr)
 */
add_action('after_setup_theme', function () {
    \strarsis\Sage9Onepager\Controls::init();
});
````

3. Copy the theme blade files in this repository from [resources/views](https://github.com/strarsis/sage9-onepager-themefiles/tree/master/resources/views) to the theme.

## Further customizations
In `setup.php`:
```php
// ...and for as many page sections as there are currently (published) pages minus one (one is usually the front page above all the others):
/**
 * Set maximum amount of onepager page sections
 */
add_action('after_setup_theme', function () {
  // count of currently (published) pages minus one (one is usually the front page above all the others)
  add_filter( 'onepager_front_page_sections',function(){return wp_count_posts('page')->publish-1;});
}, 20);


// ... and for appending the template classes to each panel
function post_template_classes( $post_id) {
    $post_type = get_post_type( $post_id );
    $template_slug  = get_page_template_slug( $post_id );

    if ( empty($template_slug) /*is_page_template() equivalent for $post*/ ) {
        $classes[] = "{$post_type}-template-default";
        return $classes;
    }

    $classes[] = "{$post_type}-template";
    $template_parts = explode( '/', $template_slug );
    foreach ( $template_parts as $part ) {
        $classes[] = "{$post_type}-template-" .
                        sanitize_html_class(
                            str_replace(
                                array( '.', '/' ), '-',
                                basename( $part, '.php' )
                            )
                        );
    }

    $classes[] = "{$post_type}-template-" .
                    sanitize_html_class(
                        str_replace( '.', '-', $template_slug )
                    );

    return blade_clean_classnames($classes);
}

function post_body_classes( $post_id ) {
    $classes = post_template_classes( $post_id );

    /** Add page slug if it doesn't exist */
    if (!in_array(basename(get_permalink($post_id)), $classes)) {
        $classes[] = basename(get_permalink($post_id));
    }

    return $classes;
}

/** Clean up class names for custom templates */
function blade_clean_classnames( $classes) {
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
}

/**
 * Add classes to post_class()
 *
 * @param array $classes array with post classes.
 *
 * @return array
 */
function panel_post_classes( $classes ) {
    global $post;
    return blade_clean_classnames(
        array_merge($classes, post_body_classes($post->ID))
    );
}
add_filter( 'post_class', __NAMESPACE__ . '\\panel_post_classes' );


// ... and for skipping body classes on front page body
//     because the front page content is added as panel above the other panels
/* Remove template classes from front page body class */
function panels_front_page_body_class(array $classes) {
    if(!is_front_page()) return $classes; // skip

    $template_classes = post_body_classes(get_the_ID());
    return blade_clean_classnames(
        array_diff($classes, $template_classes)
    );
}
add_filter('body_class', __NAMESPACE__ . '\\panels_front_page_body_class', 100 );


// ... to exclude all pages on start page from (Yoast) sitemap
/**
 * Exclude pages on start page from Yoast sitemap
 *
 * @return String|Boolean
 */
/*
function exclude_included_pages_from_xml_sitemap( $url, $type, $object ) {
    if(!($type === 'post' and get_post_type($object) === 'page')) return $url;
    if(in_array($object->ID, \strarsis\Sage9Onepager\Controls::panels())) return false; // exclude
    return $url;
}
add_filter( 'wpseo_sitemap_entry', __NAMESPACE__ . '\\exclude_included_pages_from_xml_sitemap', 1, 3 );
*/
// add_filter('wpseo_enable_xml_sitemap_transient_caching', '__return_false'); // to disable Yoast sitemap caching for debugging


// ... to redirect from pages assigned to front page to front page
/**
 * Redirects from pages assigned to front page to front page
 *
 */
/*
function redirect_included_pages_to_frontpage() {
    global $post;
    if(!isset($post) or !in_array($post->ID, \strarsis\Sage9Onepager\Controls::panels())) return;
    wp_safe_redirect( home_url() );
    die();
}
add_action( 'template_redirect', __NAMESPACE__ . '\\redirect_included_pages_to_frontpage' );
*/
````

## Usage
Pages can be selected in Customizr.
Amount of pages can be modified by using the `onepager_front_page_sections` filter (would be added to `setup.php` of theme), like in the originating Twenty Seventeen theme.

## Useful resources
You can find further useful tips (linking menu items to panels, smooth scrolling) in the README of related [twentyseventeen-onepage modifications repository](https://github.com/strarsis/twentyseventeen-onepage).

## Multilanguage
Tested with [Polylang plugin](https://wordpress.org/plugins/polylang/):
Translation of pages selected to be shown on front page are correctly switched to the selected language.

## Credits
Code has been adopted from [WordPress Twenty Seventeen theme](https://github.com/WordPress/WordPress/tree/master/wp-content/themes/twentyseventeen).

## More than one page with multiple sections?
For more than one page with multiple sections, [Mesh](https://github.com/linchpin/mesh) can be used.

[Gutenberg](https://github.com/WordPress/gutenberg) could also be an option, also [Gutenblock support is planned for Mesh](https://github.com/linchpin/mesh/issues/209).
