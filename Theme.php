<?php

namespace Aivec\Welcart\Generic;

/**
 * Dynamic theme configurations
 */
class Theme
{

    /**
     * Version number used for referencing `theme.css` classes (eg. `welbtn-v4_0_4-primary-basic`).
     *
     * This is necessary for class name references because of cases in which different versions of this
     * library are being used by multiple plugins.
     */
    const VERSION = 'v4_0_4';

    /**
     * A list of all official Welcart theme stylesheets
     */
    const STYLESHEETS = [
        'welcart_basic',
        'welcart_basic-nova',
        'welcart_basic-beldad',
        'welcart_basic-bordeaux',
        'welcart_basic-carina',
        'welcart_basic-square',
        'welcart_basic-voll',
        'welcart_panetteria',
        'welcart_default',
        'glamour_tcd073',
        'iconic_tcd062',
    ];

    /**
     * Returns config based on the currently enabled Welcart theme.
     *
     * In cases where the current theme is not an official Welcart theme but is **the child** of an
     * official Welcart theme, the parent Welcart theme config will be returned.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param string $hookprefix used for registering unique global hooks relative to
     *                           a project level invokation of this method
     * @return array
     */
    public static function themeConfig($hookprefix) {
        $theme_config = [];
        $theme = wp_get_theme();
        $theme_config['name'] = '';
        $theme_config['btnclass'] = '';
        $theme_config['full_name'] = $theme->get('Name');
        $theme_config['stylesheet'] = $theme->stylesheet;

        $template = $theme->stylesheet;
        if (!in_array($template, self::STYLESHEETS, true)) {
            $template = $theme->template;
        }
        switch ($template) {
            // TCD theme quick payment confirmation screen style should be the same as wlcart_basic
            case 'glamour_tcd073':
            case 'iconic_tcd062':
            case 'welcart_basic':
                $theme_config['name'] = 'basic';
                $theme_config['classname'] = 'WelcartBasic';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'orange');
                break;
            case 'welcart_basic-nova':
                $theme_config['name'] = 'nova';
                $theme_config['classname'] = 'WelcartNova';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                break;
            case 'welcart_basic-beldad':
                $theme_config['name'] = 'beldad';
                $theme_config['classname'] = 'WelcartBeldad';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'black');
                break;
            case 'welcart_basic-bordeaux':
                $theme_config['name'] = 'bordeaux';
                $theme_config['classname'] = 'WelcartBordeaux';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                break;
            case 'welcart_basic-carina':
                $theme_config['name'] = 'carina';
                $theme_config['classname'] = 'WelcartCarina';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                break;
            case 'welcart_basic-square':
                $theme_config['name'] = 'square';
                $theme_config['classname'] = 'WelcartSquare';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'black');
                break;
            case 'welcart_basic-voll':
                $theme_config['name'] = 'voll';
                $theme_config['classname'] = 'WelcartVoll';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'teal');
                break;
            case 'welcart_panetteria':
                $theme_config['name'] = 'panetteria';
                $theme_config['classname'] = 'WelcartPanetteria';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'brown');
                break;
            case 'welcart_default':
                $theme_config['name'] = 'default';
                $theme_config['classname'] = 'WelcartDefault';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', '');
                break;
            default:
                $theme_config['name'] = apply_filters($hookprefix . '_tutils_default_name', '');
                $theme_config['classname'] = 'Base';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', '');
                break;
        }

        $theme_config['btnprimary'] = 'welbtn-' . self::VERSION . '-primary-' . $theme_config['name'];
        $theme_config['btnsecondary'] = 'welbtn-' . self::VERSION . '-secondary-' . $theme_config['name'];
        $theme_config['btnsecondary_alt'] = 'welbtn-' . self::VERSION . '-secondary-alt-' . $theme_config['name'];

        return $theme_config;
    }

    /**
     * Instantiates a view class based on the current theme
     *
     * Given the fully qualified namespace of `MyPlugin\Views\MyPage`, the following file structure
     * is expected:
     *
     * MyPlugin\
     *    Views\
     *       MyPage\
     *          Base.php - At the very least, this file **MUST** exist or `null` will be returned.
     *                     The remaining theme files are *optional*.
     *          WelcartBasic.php
     *          WelcartNova.php
     *          WelcartBeldad.php
     *          WelcartBordeaux.php
     *          WelcartCarina.php
     *          WelcartSquare.php
     *          WelcartVoll.php
     *          WelcartPanetteria.php
     *          WelcartDefault.php
     *
     * The `Base` class should provide filter methods that can be overriden in child classes. Theme
     * classes (`WelcartBasic`, `WelcartNova`, etc.) should *extend* the `Base` class and override
     * `Base` class methods where needed.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param string $fullyQualifiedNamespace does not include trailing slash. In case the class
     *                                        is in the global namespace, an empty string is expected
     * @param array  $constructorParams array of one or more parameters pass to constructor
     * @return null|mixed instantiated view class if exists
     */
    public static function initThemeViewClass(
        $fullyQualifiedNamespace,
        $constructorParams = []
    ) {
        $classname = self::themeConfig('dummy')['classname'];
        $class = "{$fullyQualifiedNamespace}\\{$classname}";
        $view = null;
        if (class_exists($class)) {
            $view = new $class(...$constructorParams);
        } else {
            $class = "{$fullyQualifiedNamespace}\Base";
            $view = new $class(...$constructorParams);
        }

        return $view;
    }

    /**
     * Returns array of all Welcart theme slugs
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return string[]
     */
    public static function getAllThemeSlugs() {
        return ['basic', 'beldad', 'bordeaux', 'nova', 'carina', 'voll', 'panetteria', 'default'];
    }

    /**
     * Enqueues themes.css
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param mixed $projecturl this should be a URL pointing to the root of the theme/plugin
     *                          that uses this package. This method assumes that the file `themes.css`
     *                          which is generated by the script `./vendor/bin/welthemes` resides
     *                          in a directory by the name of `dist` in your theme/plugin root
     * @param array $deps array of dependencies for the themes.css file
     * @return void
     */
    public static function enqueueThemeCss($projecturl, $deps = []) {
        wp_enqueue_style(
            self::VERSION . '-welcart-themes',
            $projecturl . '/dist/themes.css',
            $deps,
            self::VERSION
        );
    }
}
