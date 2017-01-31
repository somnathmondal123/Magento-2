<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Icepay\IcpCore\Api;

/**
 * @api
 */
interface PaymentmethodRepositoryInterface
{
    /**
     * Create payment method service
     *
     * @param \Icepay\IcpCore\Api\Data\PaymentmethodInterface $paymentmethod
     * @return \Icepay\IcpCore\Api\Data\PaymentmethodInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Icepay\IcpCore\Api\Data\PaymentmethodInterface $paymentmethod);

    /**
     * Get info about payment method by payment method id
     *
     * @param int $paymentmethodId
     * @return \Icepay\IcpCore\Api\Data\PaymentmethodInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($paymentmethodId);

    /**
     * Retrieve blocks matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Icepay\IcpCore\Api\Data\PaymentmethodSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete payment method by identifier
     *
     * @param \Icepay\IcpCore\Api\Data\PaymentmethodInterface $paymentmethod payment method which will be deleted
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete(\Icepay\IcpCore\Api\Data\PaymentmethodInterface $paymentmethod);

    /**
     * Delete payment method by identifier
     *
     * @param int $paymentmethodId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($paymentmethodId);
}
