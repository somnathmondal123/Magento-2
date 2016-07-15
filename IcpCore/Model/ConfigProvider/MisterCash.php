<?php

namespace Icepay\IcpCore\Model\ConfigProvider;

class MisterCash extends AbstractConfigProvider
{
    /**
     * 
     */
    protected $methodCode = \Icepay\IcpCore\Model\PaymentMethod\MisterCash::CODE;

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'icepay' => [
                    'mistercash' => [
                        'paymentMethodLogoSrc' => $this->getPaymentMethodLogoSrc(),
                        'issuers' => $this->getIssuerList(),
                        'redirectUrl' => $this->getMethodRedirectUrl(),
                        'getPaymentMethodDisplayName' => $this->getPaymentMethodDisplayName()
                    ],
                ],
            ],
        ] : [];
    }

}