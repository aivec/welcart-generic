<?php
namespace Aivec\Welcart\Generic;

use Exception;

/**
 * Welcart Generic Utility functions.
 */
final class WelcartUtils {

    /**
     * Prevents instantiation of this class.
     *
     * @throws Exception // thrown if instantiation is attempted.
     */
    private function __construct() {
        throw new Exception("Can't create instance of this class");
    }

    /**
     * Same functionality as wp's localize without the script injection part
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param array $array
     * @return string
     */
    public static function localizeAssociativeArray($array) {
        foreach ((array) $array as $key => $value) {
            if (!is_scalar($value)) {
                continue;
            }
            $array[$key] = html_entity_decode((string) $value, ENT_QUOTES, 'UTF-8');
        }
        return wp_json_encode($array);
    }

    /**
     * Returns true if current page is `/usces-cart` regardless of `$usces->page`'s value
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return bool
     */
    public static function isCartSlug() {
        global $usces;

        $flag = false;
        if (!isset($usces)) {
            return $flag;
        }

        if (!($usces instanceof \usc_e_shop)) {
            return $flag;
        }

        $url = '';
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']));
        }
        if ($usces->is_cart_page($url)) {
            $flag = true;
        }

        return $flag;
    }

    /**
     * Returns true if on cart page
     *
     * NOTE: sometimes the `$usces->page` is not set to 'cart' even when on the cart page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return boolean
     */
    public static function isCartPage() {
        global $usces;

        $cartslug = self::isCartSlug();
        if ($cartslug === false) {
            return false;
        }

        if ($usces->page !== 'customer'
            && $usces->page !== 'delivery'
            && $usces->page !== 'ordercompletion'
            && $usces->page !== 'error'
            && $usces->page !== 'confirm'
            && $usces->page !== 'amazon_quickpay'
            && empty($_POST['aap']['toquickpay'])
            || (
                $usces->page === 'cart'
                && empty($_POST['aap']['toquickpay'])
            )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if on customer page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return boolean
     */
    public static function isCustomerPage() {
        global $usces;

        $cartslug = self::isCartSlug();
        if ($cartslug === false) {
            return false;
        }

        if ($usces->page === 'customer') {
            return true;
        }

        return false;
    }

    /**
     * Returns true if on delivery page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return boolean
     */
    public static function isDeliveryPage() {
        global $usces;

        $cartslug = self::isCartSlug();
        if ($cartslug === false) {
            return false;
        }

        if ($usces->page === 'delivery') {
            return true;
        }

        return false;
    }

    /**
     * Returns true if on cart error page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return boolean
     */
    public static function isCartErrorPage() {
        global $usces;

        $cartslug = self::isCartSlug();
        if ($cartslug === false) {
            return false;
        }

        if ($usces->page === 'error') {
            return true;
        }

        return false;
    }

    /**
     * Returns true if on confirm page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return boolean
     */
    public static function isConfirmPage() {
        global $usces;

        $flag = false;
        if (!isset($usces)) {
            return $flag;
        }

        if (!($usces instanceof \usc_e_shop)) {
            return $flag;
        }

        $url = '';
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']));
        }
        if ($usces->is_cart_page($url)) {
            if ($usces->page === 'confirm') {
                $flag = true;
            }
        }

        return $flag;
    }

    /**
     * Returns true if on order completion page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return boolean
     */
    public static function isOrderCompletionPage() {
        global $usces;

        $flag = false;
        if (!isset($usces)) {
            return $flag;
        }

        if (!($usces instanceof \usc_e_shop)) {
            return $flag;
        }

        $url = '';
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']));
        }
        if ($usces->is_cart_page($url)) {
            if ($usces->page === 'ordercompletion') {
                $flag = true;
            }
        }

        return $flag;
    }

    /**
     * Returns true if on the order list page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return boolean
     */
    public static function isOrderListPage() {
        if (is_admin()) {
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
            $action = isset($_REQUEST['order_action']) ? $_REQUEST['order_action'] : '';
            if (trim($page) === 'usces_orderlist' && empty($action)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if on the order edit page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return boolean
     */
    public static function isOrderEditPage() {
        if (is_admin()) {
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
            $action = isset($_REQUEST['order_action']) ? $_REQUEST['order_action'] : '';
            if (trim($page) === 'usces_orderlist' && $action === 'edit') {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Returns true if on the item page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \WP_Post $post
     * @return boolean
     */
    public static function isItemPage() {
        global $post;

        if (is_single() && 'item' === strtolower(trim($post->post_mime_type))) {
            return true;
        }

        return false;
    }
    
    /**
     * Returns true if on member registration page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global usc_e_shop $usces
     * @return boolean
     */
    public static function isNewMemberPage() {
        global $usces;

        $url = '';
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']));
        }
        if ($usces->is_member_page($url)) {
            if ($usces->page === 'newmemberform') {
                return true;
            }
        }

        return false;
    }

    /**
     * Creates product name from cart. Concatenates names and delimits with common
     * in case of multiple items.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop $usces
     * @return string
     */
    public static function getProductName() {
        global $usces;

        $cart = $usces->cart->get_cart();
        $label = '';
        if (!empty($cart)) {
            if (count($cart) > 0) {
                $label = $cart[0]['sku'];
                if (count($cart) > 1) {
                    for ($i = 1; $i < count($cart); $i++) {
                        $label .= ', ' . $cart[$i]['sku'];
                    }
                }
            }
        }

        return $label;
    }

    /**
     * Returns array of Welcart URLs
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return array
     */
    public static function getUscesEndpoints() {
        return [
            'usces_endpoint' => USCES_CART_URL,
            'uscesCartEndpoint' => USCES_CART_URL,
            'uscesMemberEndpoint' => USCES_MEMBER_URL,
            'uscesNewMemberEndpoint' => USCES_NEWMEMBER_URL,
        ];
    }

    /**
     * Variables to inject into our script
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @inheritDoc
     * @global \usc_e_shop $usces
     * @return array
     */
    public static function makeJSvars() {
        global $usces;

        $vars = [
            'usces_cart' => $usces->cart->get_cart(),
            'usces_entry' => isset($_SESSION['usces_entry']) ? $_SESSION['usces_entry'] : array(),
            'usces_member' => isset($_SESSION['usces_member']) ? $_SESSION['usces_member'] : array(),
            'label' => self::getProductName(),
        ];
        $vars = array_merge($vars, self::getUscesEndpoints());

        return $vars;
    }
}
