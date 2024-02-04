<?php
/*
Plugin Name: Custom Offer Price
Description: Replace "Add to Cart" button with "Offer a Price" button for specific categories.
Version: 1.04
Author: Shon Aizen
*/

// Add custom field to product settings page
function offer_price_button_add_custom_field() {
    woocommerce_wp_checkbox( array(
        'id' => 'offer_price_button',
        'label' => __( 'Display "Offer a price" button', 'offer-price-button' ),
        'description' => __( 'Enable this option to display the "Offer a price" button for this product.', 'offer-price-button' ),
    ) );
}
add_action( 'woocommerce_product_options_general_product_data', 'offer_price_button_add_custom_field' );

// Save custom field value
function offer_price_button_save_custom_field( $post_id ) {
    $offer_price_button = isset( $_POST['offer_price_button'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, 'offer_price_button', $offer_price_button );
}
add_action( 'woocommerce_process_product_meta', 'offer_price_button_save_custom_field' );

// Replace "Add to Cart" button with "Offer a Price" button
function offer_price_button_replace_add_to_cart_button() {
    global $product;

    $offer_price_button = get_post_meta( $product->get_id(), 'offer_price_button', true );

    if ( $offer_price_button === 'yes' ) {
        $offer_price_button_html = '<a href="#brave_open_popup_1082" class="button offer-price-button">' . __('לקבלת הצעת מחיר', 'offer-price-button') . '</a>';

        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
                var existingDiv = document.evaluate(\'//*[@id="content"]/div/div[2]/div[1]/div/div[2]/div[4]/div\', document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
                if (existingDiv) {
                    var offerPriceButton = document.createElement("div");
                    offerPriceButton.innerHTML = \'' . addslashes($offer_price_button_html) . '\';
                    existingDiv.appendChild(offerPriceButton);
                }
            });
          </script>';
    }
}
add_action( 'woocommerce_after_single_product', 'offer_price_button_replace_add_to_cart_button', 10 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_add_to_cart', 10 );

// Enqueue scripts and styles
function offer_price_button_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'offer-price-button', plugin_dir_url( __FILE__ ) . 'js/offer-price-button.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_style( 'offer-price-button', plugin_dir_url( __FILE__ ) . 'css/offer-price-button.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'offer_price_button_enqueue_scripts' );
