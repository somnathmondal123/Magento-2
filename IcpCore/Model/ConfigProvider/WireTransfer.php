<?php

namespace Icepay\IcpCore\Model\ConfigProvider;

class WireTransfer extends AbstractConfigProvider
{
    /**
     * 
     */
    protected $methodCode = \Icepay\IcpCore\Model\PaymentMethod\WireTransfer::CODE;

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'icepay' => [
                    'wiretransfer' => [
                        'paymentMethodLogoSrc' => $this->getPaymentMethodLogoSrc(),
                        'issuer' => $this->getIssuerList()[0],
                        'redirectUrl' => $this->getMethodRedirectUrl(),
                        'getPaymentMethodDisplayName' => $this->getPaymentMethodDisplayName()
                    ],
                ],
            ],
        ] : [];
    }

}