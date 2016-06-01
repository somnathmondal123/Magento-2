/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'icepay_icpcore_creditcard',
                component: 'Icepay_IcpCore/js/view/payment/method-renderer/creditcard'
            },
            {
               type: 'icepay_icpcore_ideal',
               component: 'Icepay_IcpCore/js/view/payment/method-renderer/ideal'
            },
            {
                type: 'icepay_icpcore_paypal',
                component: 'Icepay_IcpCore/js/view/payment/method-renderer/paypal'
            },
            {
                type: 'icepay_icpcore_giropay',
                    component: 'Icepay_IcpCore/js/view/payment/method-renderer/giropay'
            }

        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);