<?php
namespace Icepay\IcpCore\Model;

require_once(dirname(__FILE__).'/restapi/src/Icepay/API/Autoloader.php');

class Paymentmethod extends \Magento\Framework\Model\AbstractModel
{
    const ENTITY = 'icepay_icpcore_paymentmethod';


    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource =
        null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection =
        null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource,
            $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('Icepay\IcpCore\Model\ResourceModel\Paymentmethod');
    }



    public function getIcepayPaymentMethods($merchantId, $secretCode)
    {
//        $storeId = $this->getStore();

        try {
//            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//            $icepay = $objectManager->create('Icepay\IcpCore\Model\restapi\src\Icepay\API\Client');
            $icepay = new \Icepay\API\Client();
            $icepay->setApiSecret($secretCode);
            $icepay->setApiKey($merchantId);
            $icepay->setCompletedURL('...');
            $icepay->setErrorURL('...');
            return $icepay->payment->getMyPaymentMethods();

        } catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }


}