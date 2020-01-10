<?php
namespace Aivec\Welcart\Generic;

/**
 * Dynamic theme configurations
 */
class Theme {

    /**
     * Returns config based on the currently enabled Welcart theme
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param string $hookprefix used for registering unique global hooks relative to
     *                           a project level invokation of this method
     * @return array
     */
    public static function themeConfig($hookprefix) {
        $theme_config = [];
        $theme = wp_get_theme();
        $theme_config['full_name'] = $theme->get('Name');
        switch ($theme->get('Name')) {
            case 'Welcart Basic':
                $theme_config['name'] = 'basic';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'orange');
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'orange');
                break;
            case 'Welcart Nova':
                $theme_config['name'] = 'nova';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                break;
            case 'Welcart Default Theme':
                $theme_config['name'] = 'default';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'orange');
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'orange');
                break;
            default:
                $theme_config['name'] = apply_filters($hookprefix . '_tutils_default_name', '');
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', '');
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', '');
                break;
        }

        return $theme_config;
    }
}
