<?php
namespace Aivec\Welcart\Generic\Views;

/**
 * Interface for components.
 */
interface VueComponent {
    /**
     * Displays the html for this component.
     *
     * Serves as the entry point for our Vue component.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param array $config {
     *     Optional. Array or configuration options.
     *
     * @type bool $controlledComponent True if this component depends on a container for props, false if this component
     *                                 is being used in isolation by itself. Default `true`.
     * }
     * @return void echos html
     */
    public function template(array $config);

    /**
     * Returns component name as is recognized by Vue. For example, if your component
     * is named `my-component`, this method should return `myComponent`
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return string
     */
    public function getComponentName();

    /**
     * Initializes component. Should be left empty if no initialization logic is required.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return void
     */
    public function init();
}
