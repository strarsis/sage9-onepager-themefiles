## Installation
Helper functions and customizr UI setup have been offloaded to a separate (composer packaged) library 
[sage9-onepager-lib](https://github.com/strarsis/sage9-onepager-lib).

Require the library for the theme (not for the (e.g. Bedrock based) site (`site/`)!),
see [example `composer.json`](https://github.com/strarsis/sage9-onepager-themefiles/blob/master/composer.json#L12).

In the actual sage9-based theme(!) directory:
````
$ composer require strarsis/sage9-onepager-lib
````

In `setup.php`:
```php
/**
 * Add onepager controls (to Customizr)
 */
add_action('after_setup_theme', function () {
    \strarsis\Sage9Onepager\Controls::init();
});
````

## Further customization
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
/**
 * Add classes to post_class()
 *
 * @param array $classes array with post classes.
 *
 * @return array
 */
function filter_post_classes( $classes ) {
    global $post;
    $post_id   = $post->ID;
    $post_type = get_post_type( $post );

    $template_slug  = get_page_template_slug( $post_id );
    if ( empty($template_slug)/*is_page_template() for $post*/) {
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

    return $classes;
}
add_filter( 'post_class', __NAMESPACE__ . '\\filter_post_classes' );

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

## Credits
Code has been adopted from [WordPress Twenty Seventeen theme](https://github.com/WordPress/WordPress/tree/master/wp-content/themes/twentyseventeen).
