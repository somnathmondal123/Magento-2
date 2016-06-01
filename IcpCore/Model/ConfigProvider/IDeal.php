<?php

namespace Icepay\IcpCore\Model\ConfigProvider;

class IDeal extends AbstractConfigProvider
{
    /**
     * 
     */
    protected $methodCode = \Icepay\IcpCore\Model\PaymentMethod\IDeal::CODE;

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'icepay' => [
                    'ideal' => [
                        'paymentMethodLogoSrc' => $this->getPaymentMethodLogoSrc(),
                        'issuers' => $this->getIssuerList(),
                        'redirectUrl' => $this->getMethodRedirectUrl()
                    ],
                ],
            ],
        ] : [];
    }

}