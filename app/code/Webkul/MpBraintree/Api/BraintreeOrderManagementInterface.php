<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Webkul\MpBraintree\Api;

/**
 * @api
 */
interface BraintreeOrderManagementInterface
{
    /**
     * doCompleteOrderInvoice Create order invoice.
     *
     * @param Magento\Sales\Model\Order $order
     * @param array $sellerData
     *
     * return mixed
     */
    public function doCompleteOrderInvoice($order, $sellerData);

    /**
     * doSellerOrderInvoice function to create invoice seller wise.
     *
     * @param Magento\Sales\Model\Order $order
     * @param array  $cart   seller wise payment data
     * @param array  $sellerData braintree charge data of payment
     * @param string $transactionId
     *
     * return mixed
     */
    public function doSellerOrderInvoice($order, $sellerData, $transactionId);

    /**
     * doTransaction function to create payment transations.
     *
     * @param Magento\Sales\Model\Order $order
     * @param array  $sellerData
     *
     * @return mixed
     */
    public function doTransaction($order, $sellerData);

    /**
     * doVoid void transaction.
     *
     * @param int  $transactioId
     *
     * @return mixed
     */
    public function doVoid($transactioId);
}
