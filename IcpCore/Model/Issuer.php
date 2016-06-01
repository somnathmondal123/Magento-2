<?php
namespace Icepay\IcpCore\Model;


class Issuer extends \Magento\Framework\Model\AbstractModel
{

    const ENTITY = 'icepay_icpcore_issuer';


    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource =  null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection =  null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource,
            $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('Icepay\IcpCore\Model\ResourceModel\Issuer');
    }

}