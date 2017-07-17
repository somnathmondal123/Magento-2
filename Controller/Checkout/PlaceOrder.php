<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Icepay\IcpCore\Controller\Checkout;

/**
 * Class PlaceOrder
 */
class PlaceOrder extends \Icepay\IcpCore\Controller\AbstractCheckout
{

    /**
     * Checkout mode type
     *
     * @var string
     */
    protected $_checkoutType = 'Icepay\IcpCore\Model\Checkout\Checkout';


    /**
     * Submit the order
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        try {

            $this->_initCheckout();
            if($this->_checkout->initIcepayResult())
            {

                $this->_getCheckoutSession()->unsIcepayPaymentInProgress();
                
                $this->_checkout->place();

                // prepare session to success or cancellation page
                $this->_getCheckoutSession()->clearHelperData();

                // "last successful quote"
                $quoteId = $this->_getQuote()->getId();
                $this->_getCheckoutSession()->setLastQuoteId($quoteId)->setLastSuccessQuoteId($quoteId);

                // an order may be created
                $order = $this->_checkout->getOrder();
                if ($order) {
                    $this->_getCheckoutSession()->setLastOrderId($order->getId())
                        ->setLastRealOrderId($order->getIncrementId())
                        ->setLastOrderStatus($order->getStatus());
                }

                $this->_redirect('checkout/onepage/success');
                return;
            }
        } catch (ApiProcessableException $e) {
//            $this->_processIcepayApiError($e); //TODO: implement
            $this->messageManager->addExceptionMessage(
                $e,
                __('ICEPAY Gateway Error')
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                $e->getMessage()
            );
//            $this->_redirect('*/*/review');
            $this->_redirect('/');
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('We can\'t place the order.')
            );
//            $this->_redirect('*/*/review');
            $this->_redirect('/');
        }
    }


}
