<?php

namespace Icepay\IcpCore\Block\Adminhtml\Paymentmethod\Sync;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SyncButton implements ButtonProviderInterface
{

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Context
     */
    protected $context;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->authorization = $context->getAuthorization();
        $this->storeManager = $storeManager;
        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->authorization->isAllowed('Icepay_IcpCore::paymentmethod_save')) {
            $data = [
                'label' => __('Sync'),
                'on_click' => "syncPaymentMethods('" . $this->getSyncUrl() . "')",
                'class' => 'primary',
                'sort_order' => 10,
            ];
        }
        return $data;
    }

    /**
     * Get URL for sync button
     *
     * @return string
     */
    public function getSyncUrl()
    {
        return $this->storeManager->getStore()->getUrl('*/*/sync', ['_current' => true]);
    }


}
