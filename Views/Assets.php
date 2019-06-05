<?php
namespace Aivec\Welcart\Generic\Views;

/*
 * Interface for any view/container/component that requires assets to be enqueued.
 *
 * An interface is prefered over an abstract class because
 * not all views enqueue assets.
 */
interface Assets {

    /**
     * Enqueues any necessary assets for a given view.
     *
     * Represents a one-to-one relationship between the hook
     * initialized in {@see wpEnqueueInitHook()} and itself.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return void
     */
    public function enqueueAssets();

    /**
     * Registers wp_enqueue_scripts hook.
     *
     * {$this->wpEnqueueInitHook()} should be called in the contructor.
     * {add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'))}
     * should be called in this function.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @see enqueueAssets()
     * @return void
     */
    public function wpEnqueueInitHook();
}
