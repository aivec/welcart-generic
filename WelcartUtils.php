<?php
namespace Aivec\Welcart\Generic;

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
     * Returns true if on cart page
     *
     * NOTE: sometimes the $usces->page is not set to 'cart' even when on the cart page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \usc_e_shop usces
     * @return boolean
     */
    public static function isCartPage() {
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
                $flag = true;
            }
        }

        return $flag;
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
            if ($usces->page === 'customer') {
                $flag = true;
            }
        }

        return $flag;
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
            if ($usces->page === 'delivery') {
                $flag = true;
            }
        }

        return $flag;
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
     * Variables to inject into our script
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @inheritDoc
     * @global \usc_e_shop $usces
     * @return array
     */
    public static function makeJSvars() {
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

        $vars = array(
            'usces_cart' => $cart,
            'usces_entry' => isset($_SESSION['usces_entry']) ? $_SESSION['usces_entry'] : array(),
            'usces_member' => isset($_SESSION['usces_member']) ? $_SESSION['usces_member'] : array(),
            'label' => $label,
        );

        return $vars;
    }
}
