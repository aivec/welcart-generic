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
}
