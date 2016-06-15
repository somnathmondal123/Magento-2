<?php

namespace Icepay\IcpCore\Block\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;

class ErrorUrlField extends \Magento\Config\Block\System\Config\Form\Field
{

    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setReadonly('readonly');
        $element->setValue('Error url will be here');
        return $element->getElementHtml();
    }
}