<?php
namespace Aivec\Welcart\Generic\Views\Component;

/**
 * Interface for components requiring specific jsvars.
 */
interface RequiresInjection {

    /**
     * Creates any variables necessary for scripts.
     *
     * Should return an array of php vars to be sent through
     * {wp_localize_script()}. Return array to be used in
     * {@see enqueueAssets()}
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return array Array of php variables
     */
    public function injectionVariables();
}
