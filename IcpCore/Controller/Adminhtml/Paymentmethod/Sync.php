<?php
namespace Icepay\IcpCore\Controller\Adminhtml\Paymentmethod;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Sync extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    protected $paymentmethodFactory;

    protected $issuerFactory;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    protected $_encryptor;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Icepay\IcpCore\Model\PaymentmethodFactory $paymentmethodFactory,
        \Icepay\IcpCore\Model\IssuerFactory $issuerFactory,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->paymentmethodFactory = $paymentmethodFactory;
        $this->issuerFactory = $issuerFactory;
        $this->_encryptor = $encryptor;
    }
    public function execute()
    {

        //if post TODO
        $merchantId = $this->_scopeConfig->getValue('payment/icepay_settings/merchant_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $secretCode = $this->_scopeConfig->getValue('payment/icepay_settings/merchant_secret', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $secretCode = $this->_encryptor->decrypt($secretCode);
       // $activeShopID = (int)Context::getContext()->shop->id;

        $paymentMethods = null;
        if (!empty($merchantId) && !empty($secretCode))
        {
            $paymentMethod = $this->_objectManager->create('Icepay\IcpCore\Model\Paymentmethod');
            $paymentMethods= $paymentMethod->getIcepayPaymentMethods($merchantId, $secretCode);
        }

        if (!isset($paymentMethods->PaymentMethods) || !is_array($paymentMethods->PaymentMethods)) {
            return; //TODO: error
        }

        $collection = $this->paymentmethodFactory->create()->getCollection();
        foreach ($collection as $item) {
            $item->delete();
        }

        $storeId = $this->_storeManager->getStore()->getId();
        for ($i = 0; $i < count($paymentMethods->PaymentMethods); $i++)
        {

            $paymentMethodDescription = $paymentMethods->PaymentMethods[$i];

            $paymentmethod = $this->paymentmethodFactory->create();
            $paymentmethod->setCode($paymentMethodDescription->PaymentMethodCode);
            $paymentmethod->setName($paymentMethodDescription->Description);
            $paymentmethod->setDisplayName($paymentMethodDescription->Description);
            $paymentmethod->setDisplayPosition($i);
            $paymentmethod->setStoreId($storeId);
            $paymentmethod->setRawPmData(serialize($paymentMethods->PaymentMethods));
            $paymentmethod->save();


            $arrCountry = array();
            $arrCurrency = array();
            $arrMinimum = array();
            $arrMaximum = array();

            foreach($paymentMethodDescription->Issuers as $issuerDescription)
            {
                foreach ($issuerDescription->Countries as $country)
                {
                    array_push($arrCountry, trim($country->CountryCode));
                    array_push($arrMinimum, $country->MinimumAmount);
                    array_push($arrMaximum, $country->MaximumAmount);
                    $arrCurrency = $this->addCurrencies($arrCurrency, explode(',', $country->Currency));
                }

                $issuer = $this->issuerFactory->create();
                $issuer->setPaymentmethodId($paymentmethod->getId());
                $issuer->setCode($issuerDescription->IssuerKeyword);
                $issuer->setName($issuerDescription->Description);
                $issuer->setCurrencyList($this->arrEncode($arrCurrency));
                $issuer->setCountryList($this->arrEncode($arrCountry));
//                $issuer->setLanguageList($this->arrEncode());
                $issuer->setMinimumAmountList($this->arrEncode($arrMinimum));
                $issuer->setMaximumAmountList($this->arrEncode($arrMaximum));
                $issuer->save();


            }
        }


//        $resultPage = $this->resultPageFactory->create();
//        $resultPage->setActiveMenu('Icepay_IcpCore::paymentmethod');
//        $resultPage->addBreadcrumb(__('ICEPAY'), __('ICEPAY'));
//        $resultPage->addBreadcrumb(__('Manage Payment Methods'), __('Manage Payment Methods'));
//        $resultPage->getConfig()->getTitle()->prepend(__('Payment Methods'));
//        return $resultPage;

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');

    }

    public function arrEncode($arr)
    {
        return serialize($arr);
        return urlencode(serialize($arr));
    }

    private function addCurrencies($arr, $currencyArr)
    {
        foreach ($currencyArr as $currency) {
            array_push($arr, trim($currency));
        }
        return $arr;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Icepay_IcpCore::paymentmethod');
    }
}