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

namespace Webkul\MpBraintree\Gateway\Http\Client;

use Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter;
use Magento\Payment\Gateway\Http\ClientException;
use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractTransaction
 */
abstract class AbstractTransaction implements ClientInterface
{
    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var Logger
     */
    protected $_customLogger;

    /**
     * @var BraintreeAdapter
     */
    protected $adapter;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     * @param Logger $customLogger
     * @param BraintreeAdapter $transaction
     */
    public function __construct(LoggerInterface $logger, Logger $customLogger, MpBraintreeAdapter $adapter)
    {
        $this->_logger = $logger;
        $this->_customLogger = $customLogger;
        $this->adapter = $adapter;
    }

    /**
     * @inheritdoc
     */
    public function placeRequest(TransferInterface $braintreeTransferObject)
    {
        $transferData = $braintreeTransferObject->getBody();
        $log = [
            'request' => $transferData,
            'client' => static::class
        ];
        $response['object'] = [];

        try {
            $response['object'] = $this->process($transferData);
        } catch (\Exception $e) {
            $message = __($e->getMessage() ?: 'Sorry, but something went wrong');
            $this->_logger->critical($message);
            throw new ClientException($message);
        } finally {
            $log['response'] = (array) $response['object'];
            $this->_customLogger->debug($log);
        }

        return $response;
    }

    /**
     * Process http request
     * @param array $request
     * @return \Braintree\Result\Error|\Braintree\Result\Successful
     */
    abstract protected function process(array $request);
}
