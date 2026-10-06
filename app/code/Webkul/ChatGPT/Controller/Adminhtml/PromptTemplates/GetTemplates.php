<?php

namespace Webkul\ChatGPT\Controller\Adminhtml\PromptTemplates;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Webkul\ChatGPT\Helper\Data;

class GetTemplates extends Action
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
        try {
            $client = $this->helper->getPromptTemplatesClient();
            $selectedsubCategory = $this->getRequest()->getParam('subcat');
            if ($selectedsubCategory) {
                $client->post('https://keywordseverywhere.com/service/3/templates/getTemplates.php?subcat='
                .$selectedsubCategory, $this->helper->getJsonEncode([]));
                $templates = $this->helper->getJsonDecode($client->getBody(), true);
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody($this->jsonHelper
                        ->jsonEncode($templates));
            }
        } catch (\Exception $err) {
            $logger = $this->helper->getChatGPTLogger();
            $logger->error($err->getMessage());
            $response = ['error' => true, 'message' => $err->getMessage()];
            $this->getResponse()->setBody($this->jsonHelper
                    ->jsonEncode($response));
        }
    }
}
