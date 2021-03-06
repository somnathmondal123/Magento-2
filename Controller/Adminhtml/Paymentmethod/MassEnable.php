<?php

namespace Icepay\IcpCore\Controller\Adminhtml\Paymentmethod;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassEnable
 */
class MassEnable extends \Icepay\IcpCore\Controller\Adminhtml\Paymentmethod
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Icepay\IcpCore\Model\ResourceModel\Paymentmethod\CollectionFactory
     */
    protected $collectionFactory;


    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Icepay\IcpCore\Model\ResourceModel\Paymentmethod\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Icepay\IcpCore\Model\ResourceModel\Paymentmethod\CollectionFactory $collectionFactory
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $resultPageFactory, $resultForwardFactory);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setIsActive(true);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 payment method(s) have been enabled.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Icepay_IcpCore::paymentmethod_save');
    }

}