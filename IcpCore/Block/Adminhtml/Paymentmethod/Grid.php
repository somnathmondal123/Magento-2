<?php

namespace Icepay\IcpCore\Block\Adminhtml\Paymentmethod;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Icepay\IcpCore\Model\ResourceModel\Paymentmethod\Collection
     */
    protected $_paymentmethodCollection;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Icepay\IcpCore\Model\ResourceModel\Paymentmethod\Collection $paymentmethodCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Icepay\IcpCore\Model\ResourceModel\Paymentmethod\Collection $paymentmethodCollection,
        array $data = []
    ) {
        $this->_paymentmethodCollection = $paymentmethodCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No Payment Method Found'));
    }
    /**
     * Initialize the subscription collection
     *
     * @return WidgetGrid
     */
    protected function _prepareCollection()
    {
        $this->setCollection($this->_paymentmethodCollection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'paymentmethod_id',
            [
                'header' => __('ID'),
                'index' => 'paymentmethod_id',
                'type'  => 'number',
            ]
        );
        $this->addColumn(
            'is_active',
            [
                'header' => __('Active'),
                'index' => 'is_active',
                'editable'  => true,
                'type' => 'checkbox',
//                'frame_callback' => [$this, 'decorateStatus']
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'type' => 'text'
            ]
        );
        $this->addColumn(
            'display_name',
            [
                'header' => __('Display Name'),
                'index' => 'display_name',
                'type' => 'text'
            ]
        );
        return $this;
    }

//    public function decorateStatus($value) {
//        $class = '';
//        switch ($value) {
//            case 'pending':
//                $class = 'grid-severity-minor';
//                break;
//            case 'approved':
//                $class = 'grid-severity-notice';
//                break;
//            case 'declined':
//            default:
//                $class = 'grid-severity-critical';
//                break;
//        }
//        return '<span class="' . $class . '"><span>' . $value . '</span>
//</span>';
//    }

}