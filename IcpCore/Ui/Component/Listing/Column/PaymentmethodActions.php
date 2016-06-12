<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Icepay\IcpCore\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Class PaymentMethod Actions
 */
class PaymentmethodActions extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'icepay_icpcore/paymentmethod/edit',
                        ['id' => $item['paymentmethod_id']]
                    ),
                    'label' => __('Edit'),
                    'hidden' => false,
                ];

                if($item['is_active']) {
                    $item[$this->getData('name')]['disable'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'icepay_icpcore/paymentmethod/toggle',
                            ['id' => $item['paymentmethod_id']]
                        ),
                        'label' => __('Disable'),
                        'hidden' => false,
                    ];
                }
                else
                {
                    $item[$this->getData('name')]['enable'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'icepay_icpcore/paymentmethod/toggle',
                            ['id' => $item['paymentmethod_id']]
                        ),
                        'label' => __('Enable'),
                        'hidden' => false,
                    ];
                }
            }
        }

        return $dataSource;
    }
}