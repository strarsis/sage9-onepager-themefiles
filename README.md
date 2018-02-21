## Usage
Helper functions and customizr UI setup have been offloaded to a separate (composer packaged) library 
[sage9-onepager-lib](https://github.com/strarsis/sage9-onepager-lib).

Require the library for the theme (not for the (e.g. Bedrock based) site (`site/`)!),
see [example `composer.json`](https://github.com/strarsis/sage9-onepager-themefiles/blob/master/composer.json#L12).

In `setup.php`:
```php
add_action('after_setup_theme', function () {
    \Onepager_Extension_Controls::init();
});
````

Pages can be selected in Customizr.
Amount of pages can be modified by using the `onepager_front_page_sections` filter (would be added to `setup.php` of theme), like in the originating Twenty Seventeen theme.

## Credits
Code has been adopted from [WordPress Twenty Seventeen theme](https://github.com/WordPress/WordPress/tree/master/wp-content/themes/twentyseventeen).
