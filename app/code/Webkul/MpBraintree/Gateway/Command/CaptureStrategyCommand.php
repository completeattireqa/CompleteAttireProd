<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Gateway\Command;

use Braintree\Transaction;
use Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter;
use Magento\Braintree\Model\Adapter\BraintreeSearchAdapter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Payment\Gateway\Command;
use Magento\Payment\Gateway\Command\CommandPoolInterface;
use Magento\Payment\Gateway\CommandInterface;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Webkul\MpBraintree\Gateway\Helper\SubjectReader;
use Magento\Sales\Api\Data\OrderPaymentInterface;
use Magento\Sales\Api\TransactionRepositoryInterface;
use Magento\Sales\Api\Data\TransactionInterface;

/**
 * Class CaptureStrategyCommand
 * @SuppressWarnings(PHPMD)
 */
class CaptureStrategyCommand implements CommandInterface
{

    /**
     * Braintree capture command
     */
    const CAPTURE = 'settlement';


    /**
     * @var CommandPoolInterface
     */
    private $braintreeCommandPool;

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * @var MpBraintreeAdapter
     */
    private $braintreeAdapter;

    /**
     * @var BraintreeSearchAdapter
     */
    private $braintreeSearchAdapter;

    /**
     * Constructor
     *
     * @param CommandPoolInterface $braintreeCommandPool
     * @param TransactionRepositoryInterface $repository
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SubjectReader $subjectReader
     * @param MpBraintreeAdapter $braintreeAdapter
     * @param BraintreeSearchAdapter $braintreeSearchAdapter
     */
    public function __construct(
        CommandPoolInterface $braintreeCommandPool,
        TransactionRepositoryInterface $transactionRepository,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SubjectReader $subjectReader,
        MpBraintreeAdapter $mpBraintreeAdapter,
        BraintreeSearchAdapter $braintreeSearchAdapter
    ) {
        $this->braintreeCommandPool = $braintreeCommandPool;
        $this->transactionRepository = $transactionRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->subjectReader = $subjectReader;
        $this->braintreeAdapter = $mpBraintreeAdapter;
        $this->braintreeSearchAdapter = $braintreeSearchAdapter;
    }

    /**
     * execute capture command
     *
     * @param array $commandSubject
     * @return void
     */
    public function execute(array $commandSubject)
    {
        /** @var \Magento\Payment\Gateway\Data\PaymentDataObjectInterface $paymentDO */
        $paymentDO = $this->subjectReader->readPayment($commandSubject);

        /** @var \Magento\Sales\Api\Data\OrderPaymentInterface $paymentInfo */
        $paymentInfo = $paymentDO->getPayment();
        ContextHelper::assertOrderPayment($paymentInfo);

        $command = $this->getCommand($paymentInfo);
        $this->braintreeCommandPool->get($command)->execute($commandSubject);
    }

    /**
     * Get execution braintree command name
     * @param OrderPaymentInterface $payment
     * @return string
     */
    private function getCommand(OrderPaymentInterface $payment)
    {
        return self::CAPTURE;
    }
}
