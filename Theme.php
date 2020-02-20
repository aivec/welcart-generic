<?php
namespace Aivec\Welcart\Generic;

/**
 * Dynamic theme configurations
 */
class Theme {

    const VERSION = 'v3_0_0';

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
        $theme_config['name'] = '';
        $theme_config['btnclass'] = '';
        $theme_config['full_name'] = $theme->get('Name');
        $theme_config['stylesheet'] = $theme->stylesheet;
        switch ($theme->stylesheet) {
            case 'welcart_basic':
                $theme_config['name'] = 'basic';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'orange');
                break;
            case 'welcart_basic-nova':
                $theme_config['name'] = 'nova';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                break;
            case 'welcart_basic-beldad':
                $theme_config['name'] = 'beldad';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'black');
                break;
            case 'welcart_basic-bordeaux':
                $theme_config['name'] = 'bordeaux';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                break;
            case 'welcart_basic-carina':
                $theme_config['name'] = 'carina';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'red');
                break;
            case 'welcart_basic-square':
                $theme_config['name'] = 'square';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'black');
                break;
            case 'welcart_basic-voll':
                $theme_config['name'] = 'voll';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'teal');
                break;
            case 'welcart_panetteria':
                $theme_config['name'] = 'panetteria';
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'brown');
                break;
            default:
                $theme_config['name'] = apply_filters($hookprefix . '_tutils_default_name', '');
                $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', '');
                break;
        }

        if (strtolower($theme->get('Name')) === 'welcart default theme') {
            $theme_config['name'] = 'default';
            $theme_config['color'] = apply_filters($hookprefix . '_tutils_color', 'orange');
        }

        $theme_config['btnprimary'] = 'welbtn-' . self::VERSION . '-primary-' . $theme_config['name'];
        $theme_config['btnsecondary'] = 'welbtn-' . self::VERSION . '-secondary-' . $theme_config['name'];

        return $theme_config;
    }
}
