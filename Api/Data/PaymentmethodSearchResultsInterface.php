<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Icepay\IcpCore\Api\Data;

/**
 * Interface for payment method search results.
 * @api
 */
interface PaymentmethodSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get payment method list.
     *
     * @return \Icepay\IcpCore\Api\Data\PaymentmethodInterface[]
     */
    public function getItems();

    /**
     * Set payment method list.
     *
     * @param \Icepay\IcpCore\Api\Data\PaymentmethodInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
