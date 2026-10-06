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

/**
 * MpBraintree block.
 *
 * @author Webkul Software
 */
class Navigation extends \Webkul\Marketplace\Block\Account\Navigation
{

    /**
     * $config
     *
     * @var Webkul\MpBraintree\Gateway\Config\Config
     */
    protected $config;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Customer\Model\Session $customerSession,
        \Webkul\MpBraintree\Gateway\Config\Config $config,
        array $data = []
    ) {

        $this->config = $config;
        parent::__construct($context, $objectManager, $date, $customerSession, $data);
    }

    /**
     * getIsBraintreeEnable .
     *
     * @return bool
     */
    public function getIsBraintreeEnable()
    {
        return $this->config->isActive();
    }
}
