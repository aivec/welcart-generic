<?php

namespace Aivec\Welcart\Generic\Views;

/**
 * Interface for components.
 */
abstract class VueComponent
{
    /**
     * `true` if controlled component, `false` otherwise
     *
     * @var bool
     */
    public $controlledComponent;

    /**
     * Instantiates the Vue component class
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param bool $controlledComponent Default: `true`
     * @return void
     */
    public function __construct($controlledComponent = true) {
        $this->controlledComponent = $controlledComponent;
    }

    /**
     * Displays the html for this component.
     *
     * Serves as the entry point for our Vue component.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return void echos html
     */
    abstract public function template();

    /**
     * Returns component name as is recognized by Vue. For example, if your component
     * is named `my-component`, this method should return `myComponent`
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return string
     */
    abstract public function getComponentName();

    /**
     * Initializes component. Should be left empty if no initialization logic is required.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return void
     */
    abstract public function init();
}
