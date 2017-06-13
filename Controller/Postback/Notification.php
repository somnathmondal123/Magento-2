<?php


namespace Icepay\IcpCore\Controller\Postback;

//TODO: replace
require_once(dirname(__FILE__) . '/../../Model/restapi/src/Icepay/API/Autoloader.php');
use Magento\Store\Model\ScopeInterface;
use Icepay_StatusCode;
use Psr\Log\LoggerInterface;


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
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor ,
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Sales\Model\Order $order,
        LoggerInterface $logger
    )
    {
        $this->_encryptor = $encryptor;
        $this->_scopeConfig = $scopeConfig;
        $this->order = $order;
        $this->logger = $logger;
        parent::__construct($context);
    }


    public function execute()
    {

        if ($this->getRequest()->isGet())
            return;

        try {

            $this->logger->debug("*******[ICEPAY] Postback\Notification*******");
            $this->logger->debug(['request' => $this->getRequest()]);

            $orderID = preg_replace('/[^a-zA-Z0-9_\s]/', '', strip_tags($this->getRequest()->getParam('OrderID')));

            $this->order->loadByIncrementId($orderID);

            if (!$this->order->getId()) {

                $this->logger->error(sprintf('Order %s not found!', $orderID));
                $this->logger->debug(sprintf('Order %s not found!', $orderID));

                $this->getResponse()->setStatusHeader(404, '1.1', 'Not Found');
                return;

            };

            if (!$this->initIcepayPostback($this->order->getStore())) {
                $this->logger->error('Postback inicialization\validation failed.');
                $this->logger->debug(sprintf('Postback inicialization\validation failed.  %s '), print_r($this->getRequest()->getPost(), true));
                $this->getResponse()->setStatusHeader(403, '1.1', 'Forbidden');
                return;
            }

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

        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->getResponse()->setStatusHeader(500, '1.1', 'Internal Server Error');
            return;
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