<?php
/**
 * @category   Webkul
 * @package    Webkul_MpSellerReason
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */
namespace Webkul\EmailUnsubscribe\Controller\Adminhtml\Reason;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Webkul\EmailUnsubscribe\Model\Reason;

class Edit extends Action
{
    /**
     * backend session
     * @var Session
     */
    protected $session;

    /**
     * registry
     * @var Registry
     */
    protected $registry;

    /**
     * object of reason model
     * @var Reason
     */
    protected $reason;

    /**
     * @param Context                        $context
     * @param Registry                       $registry
     * @param Reason                         $reason
     * @param PageFactory                    $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Reason $reason,
        PageFactory $resultPageFactory
    ) {
        $this->reason = $reason;
        $this->registry = $registry;
        $this->session = $context->getSession();
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
    
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $reasonModel = $this->reason;
        if ($this->getRequest()->getParam('id')) {
            $reasonModel->load($this->getRequest()->getParam('id'));
        }
        $data = $this->session->getFormData(true);
        if (!empty($data)) {
            $reasonModel->setData($data);
        }
        $this->registry->register('reason_formdata', $reasonModel);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(
            $reasonModel->getId() ? __('Update Reason ').$reasonModel->getReason() : __('New Reason')
        );
        $resultPage->addBreadcrumb(__('Manage Reasons'), __('Manage Reasons'));
        return $resultPage;
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_EmailUnsubscribe::reason_view');
    }
}
