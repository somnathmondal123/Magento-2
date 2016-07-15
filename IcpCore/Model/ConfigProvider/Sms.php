<?php

namespace Icepay\IcpCore\Model\ConfigProvider;

class Sms extends AbstractConfigProvider
{
    /**
     * 
     */
    protected $methodCode = \Icepay\IcpCore\Model\PaymentMethod\Sms::CODE;

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'icepay' => [
                    'sms' => [
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