<?php

namespace Webkul\ChatGPT\Controller\Adminhtml\Chatgpt;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Webkul\ChatGPT\Helper\Data;

class Config extends Action
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
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;
     /**
      * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
      */
    protected $date;
     /**
      * @var \Magento\Catalog\Model\ProductFactory
      */
    protected $productFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param Data $helper
     */

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        Data $helper
    ) {
        $this->helper = $helper;
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->productFactory = $productFactory;
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }
    
    /**
     * Execute
     */
    public function execute()
    {
        $active = $this->helper->getModuleConfig($this->getRequest()->getParam('storeId'))['active'];
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($this->jsonHelper
               ->jsonEncode($active));
    }
}
