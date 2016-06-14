/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*browser:true*/
/*global define*/
define(
    [
        'jquery',
        'Icepay_IcpCore/js/view/payment/method-renderer/icepay-payment-abstract',
        'ko',
        'Magento_Checkout/js/checkout-data',
        'Magento_Checkout/js/action/select-payment-method',
    ],
    function ($, Component, ko, checkoutData, selectPaymentMethodAction) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Icepay_IcpCore/payment/paypal'
            },

            getCode: function() {
                return 'icepay_icpcore_paypal';
            },

            isActive: function() {
                return true;
            },

            /** Returns payment logo image path */
            getPaymentLogoSrc: function() {
                return window.checkoutConfig.payment.icepay.paypal.paymentMethodLogoSrc;
            },

            getPaymentMethodDisplayName: function() {
                return window.checkoutConfig.payment.icepay.paypal.getPaymentMethodDisplayName;
            },

            initObservable: function () {

                this.issuerCode = window.checkoutConfig.payment.icepay.paypal.issuer.code;

                return this;
            },


            selectPaymentMethod: function() {
                selectPaymentMethodAction(this.getData());
                checkoutData.setSelectedPaymentMethod(this.item.method);
                return true;
            },

            getData: function() {

                return {
                    "method": this.item.method,
                    "po_number": null,
                    "additional_data": {
                        "issuer" : this.issuerCode
                    }
                };
            },

        });
    }
);
