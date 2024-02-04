(function ($) {
    $(window).on('load', function () {
        var offerPriceButton = $('.offer-price-button');
        console.log('JS LOADD');
        if (offerPriceButton.length && offerPriceButton.is(':visible')) {
            // Clone the "Offer a Price" button
            var clonedButton = offerPriceButton.clone();

            // Find the Elementor div and append the cloned button
            var elementorDiv = $('#content > div > div.elementor.elementor-200.elementor-location-single.post-1009.product.type-product.status-publish.has-post-thumbnail.product_cat-all-rings.ast-article-single.ast-woo-product-no-review.desktop-align-center.tablet-align-left.mobile-align-center.first.instock.taxable.shipping-taxable.product-type-simple.product');

            if (elementorDiv.length) {
                // Append the cloned "Offer a Price" button to the Elementor div
                elementorDiv.find('.elementor-add-to-cart--layout-stacked').append(clonedButton);

                // Hide the original "Offer a Price" button
                offerPriceButton.hide();
            } else {
                console.error('Elementor div not found. Check your selector.');
            }
        }
    });
})(jQuery);
