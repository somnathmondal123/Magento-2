<?php

namespace Icepay\IcpCore\Controller\Checkout;

use Magento\Checkout\Model\Type\Onepage;

class Start extends \Icepay\IcpCore\Controller\AbstractCheckout
{
    
    /**
     * Checkout mode type
     *
     * @var string
     */
    protected $_checkoutType = 'Icepay\IcpCore\Model\Checkout\Checkout';
    
    /**
     * Start ICEPAY Checkout
     *
     * @return void
     */
    public function execute()
    {

        //TODO: check case with multiple parallel transactions
        if (!empty($this->_checkoutSession->getIcepayTransactionData())) {
            $this->_getCheckoutSession()->unsIcepayTransactionData();
            $this->reactivateQuote();
        }

        try {
            $this->_initCheckout();

//            $customerData = $this->_customerSession->getCustomerDataObject();
            $quoteCheckoutMethod = $this->_getQuote()->getCheckoutMethod();
            
            if ((!$quoteCheckoutMethod || $quoteCheckoutMethod != Onepage::METHOD_REGISTER)
                && !$this->_objectManager->get('Magento\Checkout\Helper\Data')->isAllowedGuestCheckout(
                    $this->_getQuote(),
                    $this->_getQuote()->getStoreId()
                )
            ) {
                $this->messageManager->addNoticeMessage(
                    __('To check out, please sign in with your email address.')
                );

                $this->_objectManager->get('Magento\Checkout\Helper\ExpressRedirect')->redirectLogin($this);
                $this->_customerSession->setBeforeAuthUrl($this->_url->getUrl('*/*/*', ['_current' => true]));

                return;
            }

            $success = $this->_checkout->start(
                $this->_url->getUrl('*/*/placeorder'),
                $this->_url->getUrl('*/*/cancel')
            );
            $url = $this->_checkout->getRedirectUrl();
            if ($success && $url) {
                $this->getResponse()->setRedirect($url);
                return;
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addExceptionMessage($e, $e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('Can\'t start Icepay Checkout.')
            );
        }

        $this->reactivateQuote();
        $this->_redirect('checkout/cart');
    }
}
