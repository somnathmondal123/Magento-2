<?php

namespace Icepay\IcpCore\Model\ResourceModel;
class Issuer extends
    \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function _construct() {
        $this->_init('icepay_icpcore_issuer', 'issuer_id');
    }
}