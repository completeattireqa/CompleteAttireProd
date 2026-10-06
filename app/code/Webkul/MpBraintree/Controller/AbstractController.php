<?php
/**
 * Webkul Software.
 *
 * @category Webkul
 *
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MpBraintree\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Webkul\MpBraintree\Helper\Data as BraintreeHelper;
use Magento\Framework\Controller\ResultFactory;
use Webkul\MpBraintree\Gateway\Config\Config as BraintreeConfig;
use Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter;

/**
 * Mobikul API Catalog controller.
 */
abstract class AbstractController extends Action
{
    /**
     * braintree config
     *
     * @var BraintreeConfig
     */
    protected $config;

    /**
     * MpBraintreeAdapter
     *
     * @var MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * $_braintreeHelper.
     *
     * @var BraintreeHelper
     */
    protected $_braintreeHelper;

    /**
     * webhook manager
     *
     * @var Webkul\MpBraintree\Model\BraintreeHooksManager
     */
    protected $_webhookManager;

    /**
     * __construct.
     *
     * @param Context    $context
     * @param HelperData $helper
     */
    public function __construct(
        Context $context,
        BraintreeHelper $braintreeHelper,
        MpBraintreeAdapter $adapter,
        BraintreeConfig $config,
        \Webkul\MpBraintree\Api\BraintreeHooksManagerInterface $webhookManager
    ) {
        $this->_braintreeHelper = $braintreeHelper;
        $this->adapter = $adapter;
        $this->config = $config;
        $this->_webhookManager = $webhookManager;
        parent::__construct($context);
    }
}
