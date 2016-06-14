<?php

namespace Icepay\IcpCore\Model\ConfigProvider;

class GiroPay extends AbstractConfigProvider
{
    /**
     * 
     */
    protected $methodCode = \Icepay\IcpCore\Model\PaymentMethod\GiroPay::CODE;

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'icepay' => [
                    'giropay' => [
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