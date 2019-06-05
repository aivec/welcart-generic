<?php
namespace Aivec\Welcart\Generic\Views;

/**
 * Interface for components.
 */
interface Component {
    /**
     * Displays the html for this component.
     *
     * Serves as the entry point for our Vue component.
     * Should be invoked with an action hook registered in the
     * constructor like so:
     *
     * add_action('aap_<component_prefix>_component_view', array($this, 'entryPoint'));
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return void echos html
     */
    public function entryPoint();
}
