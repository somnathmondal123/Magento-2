<?php

namespace Icepay\IcpCore\Block\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;

class PostbackUrlField extends \Magento\Config\Block\System\Config\Form\Field
{

    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setReadonly('readonly');
        $element->setValue('Postback url will be here');
        return $element->getElementHtml();
    }
}