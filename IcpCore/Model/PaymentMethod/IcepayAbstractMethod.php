<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Icepay\IcpCore\Model\PaymentMethod;

require_once(dirname(__FILE__).'/../restapi/src/Icepay/API/Autoloader.php');

//use Magento\Paypal\Model\Api\Nvp;
//use Magento\Paypal\Model\Api\ProcessableException as ApiProcessableException;
//use Magento\Paypal\Model\Express\Checkout as ExpressCheckout;
//use Magento\Sales\Api\Data\OrderPaymentInterface;
//use Magento\Sales\Model\Order\Payment;
use Magento\Sales\Model\Order\Payment\Transaction;
//use Magento\Quote\Model\Quote;
//use Magento\Store\Model\ScopeInterface;


class IcepayAbstractMethod extends \Magento\Payment\Model\Method\AbstractMethod
{

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $_moduleList;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_localeDate;

    protected $paymentmethodFactory;

    protected $icepayMethodCode;

    protected $paymentMethodInformation;

    /**
     * @var Transaction\BuilderInterface
     */
    protected $transactionBuilder;


//    /**
//     * @param \Magento\Framework\Model\Context $context
//     * @param \Magento\Framework\Registry $registry
//     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
//     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
//     * @param \Magento\Payment\Helper\Data $paymentData
//     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
//     * @param Logger $logger
//     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
//     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
//     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
//     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
//     * @param array $data
//     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
//* @param Transaction\BuilderInterface $transactionBuilder
//     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Icepay\IcpCore\Model\PaymentmethodFactory $paymentmethodFactory,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Sales\Model\Order\Payment\Transaction\BuilderInterface $transactionBuilder,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data
        );

        $this->paymentmethodFactory = $paymentmethodFactory;
        $this->transactionBuilder = $transactionBuilder;

        $this->_moduleList = $moduleList;
        $this->_localeDate = $localeDate;

    }


    private function initPaymentMethodInformation()
    {
        $collection = $this->paymentmethodFactory
            ->create()
            ->getCollection()
            ->addFieldToFilter('store_id', '1') //TODO store_id
            ->setPageSize(1);

        if(count($collection)> 0)
        {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $mt = $objectManager->create('Icepay_Webservice_Paymentmethod');
            $pm= $collection->getFirstItem();
            $method = $mt->loadFromArray(unserialize($pm->getRawPmData()));

            $this->paymentMethodInformation = $method;
            
           // return $method;
        }
    }


    /**
     * Determine method availability based on quote amount, country and currency
     *
     * @param \Magento\Quote\Api\Data\CartInterface|null $quote
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        //TODO: Refactor!
        if ($quote)
        {
            if ($this->paymentMethodInformation == null) {
                $this->initPaymentMethodInformation();
            }

            $pMethod = $this->paymentMethodInformation
                ->filterByCurrency($quote->getBaseCurrencyCode())
                ->filterByCountry('NL')
                ->filterByAmount($quote->getBaseGrandTotal() * 100);

            $available = false;
            foreach ($pMethod->getFilteredPaymentmethods() as $value)
            {
                if ($value->PaymentMethodCode === $this->icepayMethodCode)
                {
                    $available = true;
                    break;
                }
            }
            if(!$available) return false;
        }

        return parent::isAvailable($quote);
    }

//    /**
//     * Availability for currency
//     *
//     * @param string $currencyCode
//     * @return bool
//     */
//    public function canUseForCurrency($currencyCode)
//    {
//        //TODO
//        return true;
//    }


    protected function getIssuerList($paymentMethodCode)
    {
        if($this->paymentMethodInformation == null)
        {
            $this->initPaymentMethodInformation();
        }

        $pMethod = $this->paymentMethodInformation->selectPaymentMethodByCode($paymentMethodCode);
        return $pMethod->getIssuers();
    }


    public function getIcepayMethodCode()
    {
        return $this->icepayMethodCode;
    }


    public function assignData(\Magento\Framework\DataObject $data)
    {
        parent::assignData($data);

        if (is_array($data) || $data instanceof \Magento\Framework\DataObject) {
            $this->getInfoInstance()->setAdditionalInformation('issuer', $data['issuer']);
        }
        return $this;
    }

    /**
     * Payment capturing
     *
     * @param \Magento\Payment\Model\InfoInterface $payment
     * @param float $amount
     * @return $this
     * @throws \Magento\Framework\Validator\Exception
     */
    public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        throw new \Magento\Framework\Validator\Exception(__('Payment Capture is not supported in this version'));
    }

    /**
     * Authorize payment
     *
     * @param \Magento\Framework\DataObject|\Magento\Payment\Model\InfoInterface|Payment $payment
     * @param float $amount
     * @return $this
     */
    public function authorize(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        throw new \Magento\Framework\Validator\Exception(__('Payment Authorize is not supported in this version'));
    }

    /**
     * Order payment
     *
     * @param \Magento\Framework\DataObject|\Magento\Payment\Model\InfoInterface|Payment $payment
     * @param float $amount
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function order(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        $icepayTransactionData = $this->_checkoutSession->getIcepayTransactionData();
        if (!isset($icepayTransactionData)) {
            throw new \Exception('ICEPAY result is not set. Order is canceled or already created.');
        } else {
            $this->_importToPayment($icepayTransactionData, $payment);
        }

        $order = $payment->getOrder();
        $orderTransactionId = $payment->getTransactionId();

        $state = \Magento\Sales\Model\Order::STATE_PROCESSING;
        $status = 'processing';

        $formattedPrice = $order->getBaseCurrency()->formatTxt($amount);
        if ($payment->getIsTransactionPending()) {
            $message = __('The ordering amount of %1 is pending approval on the payment gateway.', $formattedPrice);
            $state = \Magento\Sales\Model\Order::STATE_PAYMENT_REVIEW;
        } else {
            $message = __('Ordered amount of %1', $formattedPrice);
        }

        $payment->setParentTransactionId($orderTransactionId);

        $transaction = $this->transactionBuilder->setPayment($payment)
            ->setOrder($order)
            ->setTransactionId($payment->getTransactionId())
            ->build(Transaction::TYPE_ORDER);
        $payment->addTransactionCommentsToOrder($transaction, $message);


        $order->setState($state)
            ->setStatus($status);

        $payment->setSkipOrderProcessing(true);

        $this->_checkoutSession->unsIcepayTransactionData();

        return $this;
    }


    /**
     * Import payment info to payment
     *
     * @param Icepay_Result $icepayResult
     * @param Payment $payment
     * @return void
     */
    protected function _importToPayment($icepayResult, $payment)
    {
        
        $payment->setTransactionId(
            $icepayResult->transactionID
        )->setIsTransactionClosed(
            0
        );

        //TODO: refactor
        if($icepayResult->statusCode === "OPEN") {
            $payment->setIsTransactionPending(true);
        }
        if($icepayResult->statusCode === "OK") {
            $payment->setIsTransactionApproved(true);
        }

    }

}