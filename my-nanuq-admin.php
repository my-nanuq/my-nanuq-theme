<?php

/**
 *
 */
add_filter('woocommerce_variable_product_bulk_edit_actions', function() {
    echo "<optgroup label='" . __( 'Allow Backorders?', 'woocommerce' ) . "'>";
    echo "  <option value='no'>" . __( 'Do not allow', 'woocommerce' ) . "</option>";
    echo "  <option value='notify'>" . __( 'Allow, but notify customer', 'woocommerce' ) . "</option>";
    echo "  <option value='yes'>" . __( 'Authorize', 'woocommerce' ) . "</option>";
    echo "</optgroup>";
});

/**
 * @var string $bulk_action
 * @var array $data
 * @var int $product_id
 * @var array $variations
*/
add_action('woocommerce_bulk_edit_variations', function($bulk_action, $data, $product_id, $variations) {
    /** @global $wpdb wpdb */
    global $wpdb;

    /** @var int $variation_id */
    foreach($variations as $variation_id) {
        update_post_meta($variation_id, '_backorders', wc_clean($bulk_action));
    }
}, 10, 4);
