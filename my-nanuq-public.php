<?php

add_action('woocommerce_before_add_to_cart_button', function () {
    ob_start();
    include(dirname(__FILE__) . '/woocommerce/combo-dessin.php');
    echo ob_get_clean();
});

add_action('woocommerce_add_to_cart_validation', function($bool, $product_id, $quantity) {
    if (empty($_REQUEST['dessin'])) {
        wc_add_notice(__('Veuillez choisir un dessin', 'my-nanuq'), 'error');
        return false;
    }
    return true;
}, 10, 3);

/**
 * @var array $cart_item_data
 * @var int $product_id
 */
add_action('woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {
    if (isset($_REQUEST['dessin'])) {
        $cart_item_data['dessin'] = $_REQUEST['dessin'];
        $cart_item_data['unique_key'] = md5(microtime().rand());
    }
    return $cart_item_data;
}, 10, 2);

/**
 * @var array $cart_data
 * @var array $cart_item
 */
add_filter('woocommerce_get_item_data', function($cart_data, $cart_item = null) {
    /** @var array $custom_items */
    $custom_items = array();

    // Woo 4.4.2
    if (!empty($cart_data)) {
        $custom_items = $cart_data;
    }
    if ($cart_item != null && isset($cart_item['dessin'])) {
        $custom_items[] = array("name" => __("Dessin", "my-nanuq"), "value" => $cart_item["dessin"]);
    }
    return $custom_items;
}, 10, 2);

/**
 * @var int $item_id
 * @var array $values
 * @var string $cart_item_key
 */
add_action('woocommerce_add_order_item_meta', function($item_id, $values, $cart_item_key) {
    if (isset($values['dessin'])) {
        wc_add_order_item_meta($item_id, "dessin", $values["dessin"]);
    }
}, 10, 3);