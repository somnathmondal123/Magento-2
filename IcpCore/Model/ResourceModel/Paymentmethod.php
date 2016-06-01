<?php

namespace Icepay\IcpCore\Model\ResourceModel;
class Paymentmethod extends
    \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function _construct() {
        $this->_init('icepay_icpcore_paymentmethod', 'paymentmethod_id');
    }
}