<?php

namespace Webkul\ChatGPT\Controller\Adminhtml\Chatgpt;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Webkul\ChatGPT\Helper\Data;
use Magento\Ui\Component\MassAction\Filter;

class Index extends Action
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
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param Data $helper
     * @param Filter $filter
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        Data $helper,
        Filter $filter,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection
    ) {
        $this->helper = $helper;
        $this->resultPageFactory = $pageFactory;
        $this->messageManager = $messageManager;
        $this->filter = $filter;
        $this->productCollection = $productCollection;
        parent::__construct($context);
    }

    /**
     * Execute
     */
    public function execute()
    {
        try {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Run Profile'));
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } catch (\Exception $e) {
            $this->helper->getChatGPTLogger()->warning('chatGPT index controller '.$e->getMessage());
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
        return $this->_authorization->isAllowed('Webkul_ChatGPT::config_chatgpt');
    }
}
