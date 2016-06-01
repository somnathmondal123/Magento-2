<?php
namespace Icepay\IcpCore\Model\ResourceModel\Paymentmethod;
/**
 * Subscription Collection
 */
class Collection extends
    \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct() {
        $this->_init('Icepay\IcpCore\Model\Paymentmethod',
            'Icepay\IcpCore\Model\ResourceModel\Paymentmethod');
    }
}