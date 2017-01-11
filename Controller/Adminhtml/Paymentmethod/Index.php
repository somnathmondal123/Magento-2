<?php
namespace Icepay\IcpCore\Controller\Adminhtml\Paymentmethod;


class Index extends \Icepay\IcpCore\Controller\Adminhtml\Paymentmethod
{
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('grid');
            return $resultForward;
        }

        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Icepay_IcpCore::paymentmethod');
        $resultPage->getConfig()->getTitle()->prepend(__('Payment Methods'));
        $resultPage->addBreadcrumb(__('ICEPAY'), __('ICEPAY'));
        $resultPage->addBreadcrumb(__('Manage Payment Methods'), __('Manage Payment Methods'));

        return $resultPage;
    }

}