<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Mpbraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\Mpbraintree\Model;

class Cron
{

    /**
     * @var Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * @var Webkul\MpBraintree\Gateway\Config
     */
    protected $config;

    /**
     * @var Webkul\MpBraintree\Logger\BraintreeLogger
     */
    protected $logger;

    /**
     * @var Webkul\MpBraintree\Model\BraintreeOrderManagement
     */
    protected $braintreeOrderManager;

    public function __construct(
        \Webkul\MpBraintree\Gateway\Config\Config $config,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        \Webkul\MpBraintree\Api\BraintreeOrderManagementInterface $braintreeOrderManager,
        \Webkul\MpBraintree\Logger\BraintreeLogger $logger
    ) {

        $this->adapter = $adapter;
        $this->config = $config;
        $this->braintreeOrderManager = $braintreeOrderManager;
        $this->_logger = $logger;
    }

    /**
     * release amount from escrow
     *
     * @return void
     */
    public function releaseEscrowAmount()
    {
        try {
            $this->_logger->critical("cron executing started");
            $transactions = $this->braintreeOrderManager->getTransactionList();
            $this->_logger->critical("transaction list: ".$transactions->getSize());
            if ($transactions->getSize() > 0) {
                foreach ($transactions as $transaction) {
                    $this->_logger->critical("transaction id : ".$transaction->getTxnId());
                    if ($transaction->getOrder()->getPayment()->getMethod() != 'mpbraintree') {
                        continue;
                    }
                    $canReleaseEscrow = $this->isEscrowReleaseAllowed($transaction->getCreatedAt());
                    $this->_logger->critical("can release transaction: ". $canReleaseEscrow);
                    if ($canReleaseEscrow) {
                        $status = $this->braintreeOrderManager->escrowStatus($transaction->getTxnId());
                        $transactionStatus = $this->braintreeOrderManager->transactionStatus($transaction->getTxnId());
                        $this->_logger->critical("can release transaction: ". $status." -- ".$transactionStatus);
                        if ($status && $status == 'held' && $transactionStatus == 'settled') {
                            $this->adapter->releaseFromEscrow($transaction->getTxnId());
                            $transaction->setIsClosed(1);
                            $additionalinfo = $transaction->getAdditionalInformation();
                            if (isset($additionalinfo['seller']) && $additionalinfo['seller']) {
                                $this->braintreeOrderManager->payToSeller(
                                    $transaction->getOrder(),
                                    $additionalinfo['seller'],
                                    $transaction->getId()
                                );
                            }
                            $this->_logger->critical("payment released for transaction: ". $transaction->getTxnId());
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }
    }

    /**
     * if escrow release allowed for the day
     *
     * @param string $createdAt
     * @return bool
     */
    public function isEscrowReleaseAllowed($createdAt)
    {
        return true;
        $autoEscrow = $this->config->getEscrowAutoRelease();
        $escrowDays = $this->getEscrowDays();
        if ($autoEscrow) {
            $today = time();
            $createdTime = strtotime($createdAt);
            if (!$escrowDays) {
                $$escrowDays = 30;
            }

            $totalDifference = $today - $createdTime;
            $totalDaysDiffence = $totalDifference/86400;

            if ($escrowDays <= floor($totalDaysDiffence)) {
                return true;
            }
        }

        return false;
    }
}
