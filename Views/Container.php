<?php
namespace Aivec\Welcart\Generic\Views;

/**
 * Class for container components (ie. has children).
 *
 * Sometimes views load their own script(s) directly via
 * 'wp_enqueue_script' and so can also inject PHP vars directly via
 * 'wp_localize_script'. However, when using Webpack to pre-compile our
 * Javascript, often times we end up in a situation where one index.js
 * file is importing a child or multiple child components directly, like so:
 *
 * import childComponent from 'components/custom_fields/comp.vue'
 *
 * In this case, if 'comp.vue' requires injected PHP variables,
 * it wont be able to access any unless the container component which
 * loaded the index.js script injects them into index.js for the child.
 */
class Container {

    /**
     * Passes PHP variables required by child scripts.
     *
     * Should check to see whether child component(s) require custom variables to be passed
     * by checking {method_exists($child_component, 'injectionVariables')}. This method returns
     * an associative array to be passed to 'wp_localize_script'.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param array  $child_components
     * @param string $entry_script_slug
     * @return void
     */
    public function injectChildJSvars($child_components, $entry_script_slug) {
        $all_assets = array();
        $inject_method = 'injectionVariables';
        $assets_method = 'requiredAssets';
        foreach ($child_components as $child_component) {
            if (method_exists($child_component, $inject_method)) {
                foreach ($child_component->{$inject_method}() as $object_key => $vars) {
                    wp_localize_script(
                        $entry_script_slug,
                        $object_key,
                        $vars
                    );
                }
            }
            if (method_exists($child_component, $assets_method)) {
                foreach ($child_component->{$assets_method}() as $assetkey => $metadata) {
                    if ($metadata['load'] === true) {
                        if (!in_array($metadata['url'], $all_assets, true)) {
                            if ($metadata['has_parent_dependency'] === true) {
                                $metadata['dependencies'][] = $entry_script_slug;
                            }
                            // invokation_function is either 'wp_enqueue_script' or 'wp_enqueue_style'
                            call_user_func(
                                $metadata['invokation_function'],
                                $assetkey,
                                $metadata['url'],
                                $metadata['dependencies'],
                                $metadata['version'],
                                $metadata['in_footer']
                            );
                            $all_assets[] = $metadata['url'];
                        }
                    }
                }
            }
        }
    }
}
