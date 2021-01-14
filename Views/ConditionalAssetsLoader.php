<?php

namespace Aivec\Welcart\Generic\Views;

use Aivec\Welcart\Generic\WelcartUtils;

/**
 * Methods for conditionally loading assets based on the currently active Welcart page
 */
class ConditionalAssetsLoader
{
    /**
     * Enqueues assets if the current page is the cart page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadCartPageAssets(callable $enqueue) {
        add_action('wp_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isCartPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the customer page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadCustomerPageAssets(callable $enqueue) {
        add_action('wp_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isCustomerPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the delivery page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadDeliveryPageAssets(callable $enqueue) {
        add_action('wp_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isDeliveryPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the cart error page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadCartErrorPageAssets(callable $enqueue) {
        add_action('wp_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isCartErrorPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the order completion page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadOrderCompletionPageAssets(callable $enqueue) {
        add_action('wp_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isOrderCompletionPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the item page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadItemPageAssets(callable $enqueue) {
        add_action('wp_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isItemPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the admin item edit or registration page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadAdminItemPageAssets(callable $enqueue) {
        add_action('admin_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isAdminItemPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the order list page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadOrderListPageAssets(callable $enqueue) {
        add_action('admin_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isOrderListPage()) {
                $enqueue();
            }
        });
    }

    /**
     * Enqueues assets if the current page is the order edit page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param callable $enqueue should be a closure that calls `wp_enqueue_(style|script)`
     * @return void
     */
    public function loadOrderEditPageAssets(callable $enqueue) {
        add_action('admin_enqueue_scripts', function () use ($enqueue) {
            if (WelcartUtils::isOrderEditPage()) {
                $enqueue();
            }
        });
    }
}
