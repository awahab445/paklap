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

define([
    'uiComponent',
    'jquery',
    'ko',
    'Amazon_Payment/js/model/storage',
    'Magento_Checkout/js/model/shipping-rate-service',
    'Mageplaza_Osc/js/action/payment-total-information',
    'Mageplaza_Osc/js/model/compatible/amazon-pay',
    'Magento_Checkout/js/model/quote'
], function (Component, $, ko, amazonStorage, shippingService, getPaymentTotalInformation, amazonPay, quote) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Amazon_Payment/shipping-address/inline-form',
            formSelector: 'co-shipping-form'
        },
        initObservable: function () {
            this._super();
            amazonStorage.isAmazonAccountLoggedIn.subscribe(function (value) {
                if (value == false) {
                    window.checkoutConfig.oscConfig.isAmazonAccountLoggedIn = value;
                    amazonPay.setLogin(value);
                    if (!quote.isVirtual()) {
                        shippingService.estimateShippingMethod();
                    }
                    getPaymentTotalInformation();
                }

            }, this);

            return this;
        },
        manipulateInlineForm: function () {
            if (amazonStorage.isAmazonAccountLoggedIn()) {
                window.checkoutConfig.oscConfig.isAmazonAccountLoggedIn = true;
                amazonPay.setLogin(true);
                setTimeout(function () {
                    getPaymentTotalInformation();
                }, 1000);
            }
        }
    });
});
