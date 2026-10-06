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
namespace Webkul\MpBraintree\Block;

use Magento\Backend\Model\Session\Quote;
use Magento\Braintree\Model\Adminhtml\Source\CcType;
use Webkul\MpBraintree\Model\Ui\ConfigProvider;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template\Context;
use Magento\Payment\Block\Form\Cc;
use Magento\Payment\Helper\Data;
use Magento\Vault\Model\VaultPaymentInterface;

/**
 * Class Form
 */
class Form extends Cc
{

    /**
     * @var Quote
     */
    protected $_sessionQuote;

    /**
     * @var Config
     */
    protected $_gatewayConfig;

    /**
     * @var CcType
     */
    protected $ccType;

    /**
     * @var Data
     */
    private $paymentDataHelper;

    /**
     * @param Context $context
     * @param \Magento\Payment\Model\Config $paymentConfig
     * @param Quote $sessionQuote
     * @param GatewayConfig $gatewayConfig
     * @param CcType $ccType
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Magento\Payment\Model\Config $paymentConfig,
        Quote $sessionQuote,
        \Webkul\MpBraintree\Gateway\Config\Config $gatewayConfig,
        CcType $ccType,
        array $data = []
    ) {
        parent::__construct($context, $paymentConfig, $data);
        $this->_sessionQuote = $sessionQuote;
        $this->_gatewayConfig = $gatewayConfig;
        $this->ccType = $ccType;
    }
}
