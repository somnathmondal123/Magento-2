<?php

namespace Icepay\IcpCore\Block\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;

class SuccessUrlField extends \Magento\Config\Block\System\Config\Form\Field
{

    protected function _getElementHtml(AbstractElement $element)
    {
        $store = $this->_storeManager->getStore();
        if($store)
        {
//            $element->setValue($this->getUrl('icepay/checkout/placeporder', array('_secure' => true, '_type' => 'direct_link', '_use_rewrite' => false)));
            $element->setValue($store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK).'icepay/checkout/placeorder');
        }
        $element->setReadonly('readonly');

        return $element->getElementHtml();
    }
}