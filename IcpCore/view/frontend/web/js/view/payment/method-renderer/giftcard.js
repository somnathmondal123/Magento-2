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
                template: 'Icepay_IcpCore/payment/giftcard'
            },

            issuerList: [],

            getCode: function() {
                return 'icepay_icpcore_giftcard';
            },

            isActive: function() {
                return true;
            },

            /** Returns payment logo image path */
            getPaymentLogoSrc: function() {
                return window.checkoutConfig.payment.icepay.giftcard.paymentMethodLogoSrc;
            },

            getPaymentMethodDisplayName: function() {
                return window.checkoutConfig.payment.icepay.giftcard.getPaymentMethodDisplayName;
            },

            initObservable: function () {
                this._super().observe(['selectedIssuer', 'giftcardIssuers']);

                this.giftcardIssuers = ko.observableArray(window.checkoutConfig.payment.icepay.giftcard.issuers);

                return this;
            },


            selectPaymentMethod: function() {
                selectPaymentMethodAction(this.getData());
                checkoutData.setSelectedPaymentMethod(this.item.method);
                return true;
            },

            getData: function() {
                var selectedIssuerCode = this.selectedIssuer() ? this.selectedIssuer() : null;

                return {
                    "method": this.item.method,
                    "po_number": null,
                    "additional_data": {
                        "issuer" : selectedIssuerCode
                    }
                };
            },


        });
    }
);
