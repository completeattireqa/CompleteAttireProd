<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_EmailUnsubscribe
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\EmailUnsubscribe\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Webkul\EmailUnsubscribe\Model\UnsubscribeSellerFactory;
use Webkul\EmailUnsubscribe\Model\ReasonFactory;
use Magento\Customer\Model\CustomerFactory;

class Unsubscribe extends Template
{
    /**
     * @var UnsubscribeSellerFactory
     *
     */
    protected $_unsubscribeSellerFactory;

    /**
     * @var ReasonFactory
     *
     */
    protected $_reasonFactory;

    /**
     * @var CustomerFactory
     *
     */
    protected $_customerFactory;

    /**
     * @param Context    $context
     * @param array      $data
     */
    public function __construct(
        Context $context,
        UnsubscribeSellerFactory $unsubscribeSellerFactory,
        ReasonFactory $reasonFactory,
        CustomerFactory $customerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_unsubscribeSellerFactory = $unsubscribeSellerFactory;
        $this->_reasonFactory = $reasonFactory;
        $this->_customerFactory = $customerFactory;
    }
    
    /**
     * Get Reason Collection
     * @return array
     */
    public function getReasonCollection()
    {
        $coll = $this->_reasonFactory->create()->getCollection()
            ->addFieldToFilter(
                'status',
                1
            );
        return $coll;
    }

    /**
     * Return Save Url
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('email/index/save');
    }

    /**
     * Get if the seller is unsubscribed
     * @param int $sellerId
     * @return bool
     */
    public function isUnsubscribed($sellerId)
    {
        $coll = $this->_unsubscribeSellerFactory->create()->getCollection()
            ->addFieldToFilter(
                'seller_id',
                $sellerId
            )->addFieldToFilter(
                'status',
                1
            );
        return count($coll);
    }

    /**
     * Get the seller email
     * @param int $sellerId
     * @return string $email
     */
    public function getSellerEmail($sellerId)
    {
        $email = '';
        $customer = $this->_customerFactory->create()->load($sellerId);
        if ($customer) {
            $email = $customer->getEmail();
        }
        return $email;
    }
}
