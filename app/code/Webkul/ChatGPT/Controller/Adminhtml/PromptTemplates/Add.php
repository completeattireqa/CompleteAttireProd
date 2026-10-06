<?php

namespace Webkul\ChatGPT\Controller\Adminhtml\PromptTemplates;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Webkul\ChatGPT\Helper\Data;
use Magento\Ui\Component\MassAction\Filter;
use Webkul\ChatGPT\Model\PromptTemplatesFactory;

class Add extends Action
{
    /**
     * @var $resultPageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;
    /**
     * @var Filter
     */
    protected $filter;
     /**
      * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
      */
    protected $productCollection;
    /**
     * @var PromptTemplatesFactory $promptTemplatesFactory
     */
    protected $promptTemplatesFactory;
    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param Data $helper
     * @param Filter $filter
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection
     * @param PromptTemplatesFactory $promptTemplatesFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        Data $helper,
        Filter $filter,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        PromptTemplatesFactory $promptTemplatesFactory
    ) {
        $this->helper = $helper;
        $this->resultPageFactory = $pageFactory;
        $this->messageManager = $messageManager;
        $this->filter = $filter;
        $this->productCollection = $productCollection;
        $this->promptTemplatesFactory = $promptTemplatesFactory;
        parent::__construct($context);
    }

    /**
     * Execute
     */
    public function execute()
    {
        try {
            $rowId = (int) $this->getRequest()->getParam('entity_id');
            $rowData = $this->promptTemplatesFactory->create();
            if ($rowId) {
                $rowData = $rowData->load($rowId);
                if (!$rowData->getEntityId()) {
                    $this->messageManager->addError(__('Row data no longer exist.'));
                    $this->_redirect('*/*/index');
                    return;
                }
            }
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend($rowId ?
            __('Edit ChatGPT Prompt Template') :
            __('Add ChatGPT Prompt Template'));
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } catch (\Exception $e) {
            $this->helper->getChatGPTLogger()->warning('chatGPT prompt templates add controller '.$e->getMessage());
            $this->messageManager->addWarning($e->getMessage());
            $this->_redirect($this->_redirect->getRefererUrl());
        }
    }
    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_ChatGPT::template_prompts');
    }
}
