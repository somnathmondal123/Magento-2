<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Icepay\IcpCore\Controller\Checkout;

use Magento\Framework\Controller\ResultFactory;

class Cancel extends \Icepay\IcpCore\Controller\AbstractCheckout
{
    /**
     * Cancel ICEPAY Checkout
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {

            // if there is an order - cancel it
            $orderId = $this->getCheckoutSession()->getLastOrderId();
            /** @var \Magento\Sales\Model\Order $order */
            $order = $orderId ? $this->_orderFactory->create()->load($orderId) : false;

            if($this->cancelOrder($order, 'ICEPAY Checkout and Order have been canceled.'))
            {
                $this->messageManager->addSuccessMessage(
                    __('ICEPAY Checkout and Order have been canceled.')
                );
            }
            else
            {
                $this->messageManager->addSuccessMessage(
                    __('ICEPAY Checkout has been canceled.')
                );
            }


            $this->getCheckoutSession()->restoreQuote();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addExceptionMessage($e, $e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Unable to cancel ICEPAY Checkout'));
        }

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('checkout/cart');
    }

    
}
