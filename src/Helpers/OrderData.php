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
     * @param int $member_id
     * @return array
     */
    public static function getSubscriptionOrderData($order_id, $member_id) {
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
			WHERE con_order_id = %d AND con_member_id = %d",
            $order_id,
            $member_id
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
}
