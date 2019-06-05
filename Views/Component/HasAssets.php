<?php
namespace Aivec\Welcart\Generic\Views\Component;

/**
 * Interface for components.
 */
interface HasAssets {
    /**
     * Returns 'script' associative array of required assets with
     * meta data.
     *
     * @return array
     */
    public function requiredAssets();
}
