<?php
//
//namespace Icepay\IcpCore\Controller\Checkout;
//
//use Magento\Checkout\Model\Type\Onepage;
//
//class Start extends \Icepay\IcpCore\Controller\AbstractCheckout
//{
//
//    /**
//     * Checkout mode type
//     *
//     * @var string
//     */
//    protected $_checkoutType = 'Icepay\IcpCore\Model\Checkout\Checkout';
//
//    /**
//     * Start ICEPAY Checkout
//     *
//     * @return void
//     */
//    public function execute()
//    {
//
////        $checkoutSession = $this->_getCheckoutSession();
////
////        //TODO: check case with multiple parallel transactions
////        if (!empty($checkoutSession->getIcepayTransactionData())) {
////            $checkoutSession->unsIcepayTransactionData();
////            $this->reactivateQuote();
////        }
////        else if (!empty($checkoutSession->getIcepayPaymentInProgress() && $checkoutSession->getIcepayPaymentInProgress() )) {
////            $checkoutSession->unsIcepayPaymentInProgress(); //Temporary bugfix
////            $this->reactivateQuote();
////        }
//
//        try {
//            $this->_initCheckout();
//
//            $customerData = $this->_customerSession->getCustomerDataObject();
////            $quoteCheckoutMethod = $this->_getQuote()->getCheckoutMethod();
//            $quoteCheckoutMethod = $this->onepage->getCheckoutMethod();
//
//
//            if (!$customerData->getId() && ( (!$quoteCheckoutMethod || $quoteCheckoutMethod != Onepage::METHOD_REGISTER)
//                    && !$this->_objectManager->get('Magento\Checkout\Helper\Data')->isAllowedGuestCheckout(
//                        $this->_getQuote(),
//                        $this->_getQuote()->getStoreId()
//                    ))
//                )
//            {
//                $this->messageManager->addNoticeMessage(
//                    __('To check out, please sign in with your email address.')
//                );
//
//                $this->_objectManager->get('Magento\Checkout\Helper\ExpressRedirect')->redirectLogin($this);
//                $this->_customerSession->setBeforeAuthUrl($this->_url->getUrl('*/*/*', ['_current' => true]));
//
//                return;
//            }
//
////            $checkoutSession->setIcepayPaymentInProgress(true);
//
//            $this->checkout->place();
//
//            $success = $this->checkout->start(
//                $this->_url->getUrl('*/*/return'),
//                $this->_url->getUrl('*/*/cancel')
//            );
//            $url = $this->checkout->getRedirectUrl();
//            if ($success && $url) {
//                $this->getResponse()->setRedirect($url);
//                return;
//            }
//        } catch (\Magento\Framework\Exception\LocalizedException $e) {
////            $checkoutSession->unsIcepayPaymentInProgress();
//            $this->messageManager->addExceptionMessage($e, $e->getMessage());
//        } catch (\Exception $e) {
////            $checkoutSession->unsIcepayPaymentInProgress();
//            $this->messageManager->addExceptionMessage(
//                $e,
//                __('Can\'t start Icepay Checkout. '.$e->getMessage())
//            );
//        }
//
//        $this->reactivateQuote();
//        $this->_redirect('checkout/cart');
//    }
//}
