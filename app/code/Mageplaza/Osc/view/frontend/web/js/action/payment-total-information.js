/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Osc
 * @copyright   Copyright (c) 2017-2018 Mageplaza (http://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

define(
    [
        'jquery',
        'Magento_Checkout/js/model/quote',
        'Mageplaza_Osc/js/model/resource-url-manager',
        'mage/storage',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/payment/method-converter',
        'Magento_Checkout/js/model/payment-service',
        'Magento_Checkout/js/model/shipping-service',
        'Mageplaza_Osc/js/model/osc-loader'
    ],
    function ($,
              quote,
              resourceUrlManager,
              storage,
              errorProcessor,
              customer,
              methodConverter,
              paymentService,
              shippingService,
              oscLoader) {
        'use strict';

        return function () {
            oscLoader.startLoader();

            return storage.post(
                resourceUrlManager.getUrlForUpdatePaymentTotalInformation(quote)
            ).done(
                function (response) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                        return;
                    }
                    quote.setTotals(response.totals);
                    paymentService.setPaymentMethods(methodConverter(response.payment_methods));
                }
            ).fail(
                function (response) {
                    errorProcessor.process(response);
                }
            ).always(
                function () {
                    oscLoader.stopLoader();
                }
            );
        };
    }
);
