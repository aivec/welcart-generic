<?php
namespace Aivec\Welcart\Generic\Views;

/**
 * Interface for any view.
 */
interface LoadView {
    /**
     * True if view should be loaded, false otherwise
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return boolean
     */
    public function loadView();
}
