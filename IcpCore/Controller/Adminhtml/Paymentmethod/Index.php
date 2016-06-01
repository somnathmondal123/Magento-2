<?php
namespace Icepay\IcpCore\Controller\Adminhtml\Paymentmethod;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Icepay_IcpCore::paymentmethod');
        $resultPage->addBreadcrumb(__('ICEPAY'), __('ICEPAY'));
        $resultPage->addBreadcrumb(__('Manage Payment Methods'), __('Manage Payment Methods'));
        $resultPage->getConfig()->getTitle()->prepend(__('Payment Methods'));
        return $resultPage;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Icepay_IcpCore::paymentmethod');
    }
}