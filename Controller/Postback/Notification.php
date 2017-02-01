<?php


namespace Icepay\IcpCore\Controller\Postback;

//TODO: replace
require_once(dirname(__FILE__) . '/../../Model/restapi/src/Icepay/API/Autoloader.php');
use Magento\Store\Model\ScopeInterface;
use Icepay_StatusCode;


class Notification extends \Magento\Framework\App\Action\Action
{

    /**
     * @var Icepay_Postback
     */
    protected $icepayPostback;

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    protected $_encryptor;


    /**
     * @var \Magento\Sales\Model\Order $order
     */
    protected $order;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Sales\Model\Order $order
    )
    {
        $this->_encryptor = $encryptor;
        $this->_scopeConfig = $scopeConfig;
        $this->order = $order;
        parent::__construct($context);
    }


    public function execute()
    {

        try {
            $orderID = preg_replace('/[^a-zA-Z0-9_\s]/', '', strip_tags($this->getRequest()->getParam('OrderID')));

            $this->order->loadByIncrementId($orderID);
            if (!$this->order->getId()) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Order not found'));
            };

            if ($this->initIcepayPostback($this->order->getStore())) {

                $this->order->loadByIncrementId($this->icepayPostback->getOrderID());

                switch ($this->icepayPostback->getStatus()) {
                    case Icepay_StatusCode::OPEN:
                        $this->order->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
                        $this->order->setStatus('processing');
                        $this->order->setIsNotified(false);
                        $this->order->save();
                        break;
                    case Icepay_StatusCode::SUCCESS:
                        $this->order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING);
                        $this->order->setStatus('processing');
                        $this->order->save();
//                    $this->order->setIsNotified(false);
                        break;
                    case Icepay_StatusCode::ERROR:
                        $this->order->setState(\Magento\Sales\Model\Order::STATE_CANCELED);
                        $this->order->setStatus('processing');

                        if ($this->order->canCancel()) {
                            $this->order->cancel();
                            $this->order->setStatus('canceled');
                            $this->order->save();
                        }

                        break;
                }
            }
        } catch (Exception $e) {
            //TODO: error log
            $this->getResponse()->setStatusHeader(404, '1.1', 'Not Found');
            $this->getResponse()->setHeader('Status', '404 File not found');
        }

    }


    /**
     * Init Icepay_Result object
     *
     * @param Icepay_Result $icepayResult
     */
    public
    function initIcepayPostback($store)
    {

        $icepayPostback = $this->_objectManager->create('Icepay_Postback');

        $merchantId = $this->_scopeConfig->getValue('payment/icepay_settings/merchant_id', ScopeInterface::SCOPE_STORE, $store);
        $secretCode = $this->_scopeConfig->getValue('payment/icepay_settings/merchant_secret', ScopeInterface::SCOPE_STORE, $store);
        $secretCode = $this->_encryptor->decrypt($secretCode);

        $postback = $icepayPostback->setMerchantID($merchantId)->setSecretCode($secretCode);

        if ($postback->validate()) {

            $this->icepayPostback = $postback;
            return true;
        }
        return false;
        //throw new \Exception('Feiled to validete ICEPAY postback');
    }

}