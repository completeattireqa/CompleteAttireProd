<?php
/**
 * Webkul Software
 *
 * @category    Webkul
 * @package     Webkul_Blog
 * @author      Webkul
 * @copyright   Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license     https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Controller\Adminhtml\Customer;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Webkul\Blog\Helper\Data;
use Webkul\Blog\Api\BlogCustomerRepositoryInterface;

/**
 * MassPermitted Class
 */
class MassPermitted extends \Magento\Backend\App\Action
{
     /**
      * @var blogCustomerRepositoryInteface
      */
    protected $_blogCustomerRepository;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_massModel;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var Webkul\Blog\Helper\Data
     */
    protected $_helperData;

    /**
     * @param Action\Context                                       $context
     * @param Data                                                 $helperData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface   $scopeConfig
     * @param \Magento\Ui\Component\MassAction\Filter              $massModel
     * @param BlogCustomerRepositoryInterface                      $blogCustomerRepository
     */
   
    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Data $helperData,
        \Magento\Ui\Component\MassAction\Filter $massModel,
        BlogCustomerRepositoryInterface $blogCustomerRepository
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_helperData = $helperData;
        $this->_massModel = $massModel;
        $this->_blogCustomerRepository = $blogCustomerRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */

    public function execute()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $name = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
        $email = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
        $customerModel = $this->_blogCustomerRepository;
        $model = $this->_massModel;
        $collection = $model->getCollection($customerModel->getCustomerData());
        if ($collection->getSize()) {
            try {
                foreach ($collection as $customer) {
                    $customer->setCustomerStatus(1);
                    $customer->save();
                }
                foreach ($collection as $customer) {
                    $senderInfo = [];
                    $receiverInfo = [];
                    $receiverInfo = [
                            'name' => $customer->getName(),
                            'email' => $customer->getEmail(),
                        ];
                    $senderInfo = [
                            'name' => $name,
                            'email' => $email,
                        ];
                    $emailTempVariables = [];
                    $emailTempVariables['customerName'] = $customer->getName();
                    $this->_helperData->statusPermittedNotification(
                        $emailTempVariables,
                        $senderInfo,
                        $receiverInfo
                    );
                }
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $this->messageManager->addSuccess(__('Status changed successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wkblog/customer/managecustomer');
    }
}
