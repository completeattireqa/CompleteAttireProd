<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   BSS
 * @package    Bss_CustomerApproval
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\CustomerApproval\Plugin;

use Bss\CustomerApproval\Helper\Data;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Response\Http as responseHttp;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Bss\CustomerApproval\Model\ResourceModel\Options;

class LoginPost
{
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var Magento\Framework\App\Action\Context
     */
    protected $context;
    /**
     * @var ManagerInterface
     */
    protected $messageManager;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerInterface;
    /**
     * @var UrlInterface
     */
    protected $url;
    /**
     * @var responseHttp
     */
    protected $response;
    /**
     * @var responseHttp
     */
    protected $optionModel;

    /**
     * LoginPost constructor.
     * @param Data $helper
     * @param Context $context
     * @param responseHttp $response
     * @param CustomerRepositoryInterface $customerInterface
     * @param Options $optionModel
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        Data $helper,
        Context $context,
        responseHttp $response,
        CustomerRepositoryInterface $customerInterface,
        Options $optionModel
    ) {
        $this->helper = $helper;
        $this->_request = $context->getRequest();
        $this->messageManager = $context->getMessageManager();
        $this->url = $context->getUrl();
        $this->response = $response;
        $this->customerInterface = $customerInterface;
        $this->optionModel = $optionModel;
    }

    /**
     * @param \Magento\Customer\Controller\Account\LoginPost $subject
     * @param \Closure $proceed
     * @return $this|mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(\Magento\Customer\Controller\Account\LoginPost $subject, \Closure $proceed)
    {
        if ($this->helper->isEnable()) {
            $login =  $this->_request->getPost('login');
            $email = $login['username'];
            try {
                $customer = $this->customerInterface->get($email);
                $customerAttr = $customer->getCustomAttribute('activasion_status');
                if ($customerAttr) {
                    $customerValue = (int) $customerAttr->getValue();
                    $pending = (int) $this->optionModel->getStatusValue('Pending')['option_id'];
                    $disapprove = (int) $this->optionModel->getStatusValue('Disapproved')['option_id'];

                    if ($customerValue == $pending) {
                        $message = $this->helper->getPendingMess();
                        $loginUrl = $this->url->getUrl('customer/account/login');
                        $this->messageManager->addErrorMessage($message);
                        return $this->response->setRedirect($loginUrl);
                    } elseif ($customerValue == $disapprove) {
                        $message = $this->helper->getDisapproveMess();
                        $loginUrl = $this->url->getUrl('customer/account/login');
                        $this->messageManager->addErrorMessage($message);
                        return $this->response->setRedirect($loginUrl);
                    }
                }
                return $proceed();
            } catch (\Exception $e) {
                return $proceed();
            }
        }
        return $proceed();
    }
}
