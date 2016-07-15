<?php

namespace Icepay\IcpCore\Model\ConfigProvider;

class Paysafecard extends AbstractConfigProvider
{
    /**
     * 
     */
    protected $methodCode = \Icepay\IcpCore\Model\PaymentMethod\Paysafecard::CODE;

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'icepay' => [
                    'paysafecard' => [
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