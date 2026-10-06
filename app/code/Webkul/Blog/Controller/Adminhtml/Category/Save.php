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

namespace Webkul\Blog\Controller\Adminhtml\Category;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

/**
 * SaveCategory Class
 */
class Save extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Webkul\Blog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * @param Context                                     $context
     * @param Session                                     $customerSession
     * @param \Webkul\Blog\Model\CategoryFactory          $categoryFactory
     * @param customerRepositoryInterface                 $customerRepository
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $Date
     */

    public function __construct(
        Context $context,
        Session $customerSession,
        \Webkul\Blog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->_customerSession = $customerSession;
        $this->_date = $date;
        $this->_categoryFactory = $categoryFactory;
        $this->session = $customerSession;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParams();
            $categoryModel = $this->_categoryFactory->create();
            $resultRedirect = $this->resultRedirectFactory->create();
            if (!array_key_exists("id", $data)) {
                $categoryCollection = $categoryModel->getCollection()
                                                    ->addFieldToFilter('category', ['eq' => $data['category']]);
                if ($categoryCollection->getSize() > 0) {
                    $this->messageManager->addError(__('Category name already exists.'));
                    return $resultRedirect->setPath("wkblog/category/managecategories");
                } else {
                    $date = $this->_date->date()->format('m/d/y H:i:s');
                    $categoryModel->setData($data);
                    $categoryModel->setCreatedAt($date);
                    $categoryModel->save();
                    $this->messageManager->addSuccess(__('Category saved successfully'));
                    return $resultRedirect->setPath("wkblog/category/managecategories");
                }
            } else {
                $categoryCollection = $categoryModel->getCollection()
                                            ->addFieldToFilter('id', ['neq' => $data['id']])
                                            ->addFieldToFilter('category', ['eq' => $data['category']]);
                if ($categoryCollection->getSize() > 0) {
                    $this->messageManager->addError(__('Category name already exists.'));
                    return $resultRedirect->setPath("wkblog/category/managecategories");
                } else {
                    $date = $this->_date->date()->format('m/d/y H:i:s');
                    $categoryModel->setData($data);
                    $categoryModel->setCreatedAt($date);
                    $categoryModel->save();
                    $this->messageManager->addSuccess(__('Category saved successfully.'));
                    return $resultRedirect->setPath("wkblog/category/managecategories");
                }
            }
        }
    }
}
