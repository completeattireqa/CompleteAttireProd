<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Block;

/**
 * Webkul Blog ViewPermitted Block
 */
class ViewPermitted extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * blog customer repostitory
     *
     * @var blogCustomerRepositoryInterface
     */
    protected $_blogCustomerRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param BlogRepositoryInterface                          $blogcustomerRepository
     * @param \Webkul\Blog\Model\session                       $customerSession
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\Blog\Api\BlogCustomerRepositoryInterface $blogCustomerRepository,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->_blogCustomerRepository = $blogCustomerRepository;
        parent::__construct($context, $data);
    }
 
    /**
     * is customer permitted
     *
     * @return int
     */
    public function isCustomerPermitted()
    {
        $status = 0;
        $id = $this->_customerSession->getCustomerId();
        $customerModel = $this->_blogCustomerRepository->getCustomerDataById($id);
        foreach ($customerModel as $customer) {
            $status = $customer->getCustomerStatus();
        }
        return $status;
    }

    /**
     * is customer Login
     *
     * @return int
     */
    public function isCustomerLogin()
    {
        $id = $this->_customerSession->getCustomerId();
        if ($id) {
            return true;
        } else {
            return false;
        }
    }
}
