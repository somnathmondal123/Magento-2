<?php
namespace Icepay\IcpCore\Model;

require_once(dirname(__FILE__).'/restapi/src/Icepay/API/Autoloader.php');

class Paymentmethod extends \Magento\Framework\Model\AbstractModel
{
//    const STATUS_PENDING = 'pending';
//    const STATUS_APPROVED = 'approved';
//    const STATUS_DECLINED = 'declined';

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

//    public function setPaymentMethodsPrices($shopId, array $paymentMethods = null)
//    {
//        // null array means leave everything as is
//        if ($paymentMethods === null) {
//            return $this;
//        }
//
////        $websiteId = $this->getWebsiteForPriceScope();
////        $allGroupsId = $this->getAllCustomerGroupsId();
//
//        // build the new array of tier prices
//        $methods = [];
//        foreach ($paymentMethods as $method) {
//            $methods[] = [
//                'displayname' => '1',
//                'readablename' => '2',
//                'pm_code' => '3',
//                'position' => '4',
////                'all_groups' => ($price->getCustomerGroupId() == $allGroupsId),
////                'price_qty' => $price->getQty()
//            ];
//        }
//        $product->setData('tier_price', $methods);
//
//        return $this;
//    }


    public function getIcepayPaymentMethods($merchantId, $secretCode)
    {
        $storeId = $this->getStore();

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
//
//            if (!isset($paymentMethods->PaymentMethods) || !is_array($paymentMethods->PaymentMethods)) {
//                return;
//            }

//            $employee->setDob('1983-03-28')
//                ->setSalary(3800.00)
//                ->setVatNumber('GB123456789')
//                ->save();

//            Db::getInstance()->delete(_DB_PREFIX_ . 'icepay_pminfo', "id_shop = {$shopId}", 0, true, false);
//
//            for ($i = 0; $i < count($paymentMethods->PaymentMethods); $i++) {
//
//                $paymentMethod = $paymentMethods->PaymentMethods[$i];
//
//                $data = array
//                (
//                    'id_shop' => $shopId,
//                    'displayname' => $paymentMethod->Description,
//                    'readablename' => $paymentMethod->Description,
//                    'pm_code' => $paymentMethod->PaymentMethodCode,
//                    'position' => $i
//                );
//
//                Db::getInstance()->insert(_DB_PREFIX_ . 'icepay_pminfo', $data, false, false, Db::INSERT, false);
//            }
//
//            Db::getInstance()->delete(_DB_PREFIX_ . 'icepay_rawdata', "id_shop = {$shopId}", 0, true, false);
//            Db::getInstance()->insert(_DB_PREFIX_ . 'icepay_rawdat           Db::getInstance()->delete(_DB_PREFIX_ . 'icepay_pminfo', "id_shop = {$shopId}", 0, true, false);
//
//            for ($i = 0; $i < count($paymentMethods->PaymentMethods); $i++) {
//
//                $paymentMethod = $paymentMethods->PaymentMethods[$i];
//
//                $data = array
//                (
//                    'id_shop' => $shopId,
//                    'displayname' => $paymentMethod->Description,
//                    'readablename' => $paymentMethod->Description,
//                    'pm_code' => $paymentMethod->PaymentMethodCode,
//                    'position' => $i
//                );
//
//                Db::getInstance()->insert(_DB_PREFIX_ . 'icepay_pminfo', $data, false, false, Db::INSERT, false);
//            }
//
//            Db::getInstance()->delete(_DB_PREFIX_ . 'icepay_rawdata', "id_shop = {$shopId}", 0, true, false);
//            Db::getInstance()->insert(_DB_PREFIX_ . 'icepay_rawdat           Db::getInstance()->delete(_DB_PREFIX_ . 'icepay_pminfo', "id_shop = {$shopId}", 0, true, false);
//
//            for ($i = 0; $i < count($paymentMethods->PaymentMethods); $i++) {
//
//                $paymentMethod = $paymentMethods->PaymentMethods[$i];
//
//                $data = array
//                (
//                    'id_shop' => $shopId,
//                    'displayname' => $paymentMethod->Description,
//                    'readablename' => $paymentMethod->Description,
//                    'pm_code' => $paymentMethod->PaymentMethodCode,
//                    'position' => $i
//                );
//
//                Db::getInstance()->insert(_DB_PREFIX_ . 'icepay_pminfo', $data, false, false, Db::INSERT, false);
//            }
//
//            Db::getInstance()->delete(_DB_PREFIX_ . 'icepay_rawdata', "id_shop = {$shopId}", 0, true, false);
//            Db::getInstance()->insert(_DB_PREFIX_ . 'icepay_rawdata', array('id_shop' => $shopId, 'raw_pm_data' => serialize($paymentMethods->PaymentMethods)), false, false, Db::INSERT, false);

    }

//    /**
//     * TODO: descr
//     *
//     */
//    public function syncIcepayPaymentMethods()
//    {
//        try {
//           // $this->_getResource()->addProducts($websiteIds, $productIds);
//        } catch (\Exception $e) {
//            throw new \Magento\Framework\Exception\LocalizedException(
//                __('Blablabla.')
//            );
//        }
//        return $this;
//    }

}