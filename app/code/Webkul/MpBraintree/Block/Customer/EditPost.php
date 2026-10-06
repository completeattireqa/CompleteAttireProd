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

namespace Webkul\MpBraintree\Block\Customer;

/*
 * Webkul MpBraintree Seller Account Update
 */
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;

class EditPost extends \Magento\Framework\View\Element\Template
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $customer;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $session;

    /**
     * @var Webkul\Marketplace\Helper\Data
     */
    protected $_marketplaceHelper;

    /**
     * @var Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * @var \Webkul\MpBraintree\Gateway\Config\Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $_template = "Webkul_MpBraintree::form/edit_post.phtml";

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\ObjectManagerInterface        $objectManager
     * @param Customer                                         $customer
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        CustomerFactory $customer,
        \Magento\Customer\Model\Session $session,
        \Webkul\Marketplace\Helper\Data $marketplaceHelper,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        \Webkul\MpBraintree\Gateway\Config\Config $config,
        \Magento\Directory\Block\Data $directoryBlock,
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
        $this->customer = $customer;
        $this->session = $session;
        $this->_marketplaceHelper = $marketplaceHelper;
        $this->adapter = $adapter;
        $this->config = $config;
        $this->directoryBlock = $directoryBlock;
        parent::__construct($context, $data);
    }

    /**
     * get submerchant account details
     *
     * @return array|bool
     */
    public function getMerchantBraintreeDetails()
    {
        try {
            $customer = $this->session->getCustomer();
            $submerchantId = $customer->getBraintreeSubmerchantId();
            if ($submerchantId) {
                $submerchant = $this->adapter->findSubMerchant($submerchantId);
                return $submerchant;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isSeller()
    {
        return $this->_marketplaceHelper->isSeller();
    }

    /**
     * get terms and conditions link
     *
     * @return string
     */
    public function getTncLink()
    {
        if ($this->config->getTnC()) {
            return $this->config->getTnC();
        }
        return '#';
    }

    /**
     * braintree test mode check
     *
     * @return bool
     */
    public function isTestMode()
    {
        if ($this->config->getEnvironment() == 'sandbox') {
            return true;
        }
        return false;
    }
}
