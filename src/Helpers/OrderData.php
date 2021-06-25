<?php

namespace Aivec\Welcart\Generic\Helpers;

/**
 * Helper methods related to Welcart order data
 */
class OrderData
{
    /**
     * 継続課金会員データ取得
     *
     * @global \wpdb $wpdb
     * @param int $order_id
     * @return array
     */
    public static function getSubscriptionOrderData($order_id) {
        global $wpdb;

        $continuation_table_name = $wpdb->prefix . 'usces_continuation';
        $query = $wpdb->prepare(
            "SELECT 
			`con_acting` AS `acting`, 
			`con_order_price` AS `order_price`, 
			`con_price` AS `price`, 
			`con_next_charging` AS `chargedday`, 
			`con_next_contracting` AS `contractedday`, 
			`con_startdate` AS `startdate`, 
			`con_status` AS `status` 
			FROM {$continuation_table_name} 
			WHERE con_order_id = %d",
            $order_id
        );
        $data = $wpdb->get_row($query, ARRAY_A);
        return $data;
    }

    /**
     * Returns `true` if the order ID refers to a subscription order, `false` otherwise
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @global \wpdb $wpdb
     * @param int $order_id
     * @return bool
     */
    public static function isSubscriptionOrder($order_id) {
        global $wpdb;

        $ct = $wpdb->prefix . 'usces_continuation';
        return (bool)(int)$wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM {$ct} WHERE con_order_id = %d", (int)$order_id)
        );
    }

    /**
     * Returns the total full price for an order
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param int $order_id
     * @return int|null
     */
    public static function getTotalFullPrice($order_id) {
        global $wpdb;

        $order_table = $wpdb->prefix . 'usces_order';
        $odata = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $order_table WHERE ID = %d",
            $order_id
        ));
        if (empty($odata)) {
            return null;
        }

        $total_price
            = $odata->order_item_total_price
            - $odata->order_usedpoint
            + $odata->order_discount
            + $odata->order_shipping_charge
            + $odata->order_cod_fee
            + $odata->order_tax;

        if ($total_price < 0) {
            $total_price = 0;
        }

        return $total_price;
    }
}
