<?php

namespace Icepay\IcpCore\Model\ConfigProvider;

class CreditCard extends AbstractConfigProvider
{
    /**
     * @var string[]
     */
    protected $methodCode = \Icepay\IcpCore\Model\PaymentMethod\CreditCard::CODE;

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'icepay' => [
                    'creditcard' => [
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