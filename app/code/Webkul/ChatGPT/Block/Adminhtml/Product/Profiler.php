<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_ChatGPT
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\ChatGPT\Block\Adminhtml\Product;

use Magento\Ui\Component\MassAction\Filter;

class Profiler extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Backend\Block\Widget\Context
     */
    private $context;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    public $jsonHelper;
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var \Webkul\ChatGPT\Helper\Data
     */
    protected $helper;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollection;
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\CollectionFactory
     */
    protected $pageCollection;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection
     * @param \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollection
     * @param Filter $filter
     * @param \Webkul\ChatGPT\Helper\Data $helper
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param \Magento\Framework\App\Response\Http $response
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollection,
        Filter $filter,
        \Webkul\ChatGPT\Helper\Data $helper,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\App\Response\Http $response,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->jsonHelper = $jsonHelper;
        $this->filter = $filter;
        $this->helper = $helper;
        $this->productCollection = $productCollection;
        $this->pageCollection = $pageCollection;
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
        $this->response = $response;
    }

    /**
     * For get total imported product count.
     *
     * @return int
     */
    public function getSelectedProducts()
    {
        try {
            $params = $this->getRequest()->getParams();
            $promptTarget = $params['promptTarget'];
            $url = 'admin/dashboard/index';
            switch ($promptTarget) {
                case 'product':
                    $url = 'catalog/product/index';
                    $products = $this->filter->getCollection($this->productCollection->create());
                    $totalProducts = $products->getSize();
                    $productsIds = array_column($products->getData(), 'entity_id');
                    return ['totalCount'=>$totalProducts,'productIds'=>$productsIds];
                case 'page':
                    $url = 'cms/page/index';
                    $pages = $this->filter->getCollection($this->pageCollection->create());
                    $totalPages = $pages->getSize();
                    $pagesIds = array_column($pages->getData(), 'page_id');
                    return ['totalCount'=>$totalPages,'productIds'=>$pagesIds];
                default:
                    return ['totalCount'=> 0,'productIds'=> []];
            }
        } catch (\Exception $err) {
            $this->helper->getChatGPTLogger()->warning('chatGPT block product >> profiler '.$err->getMessage());
            $this->messageManager->addWarning($err->getMessage());
            $this->response->setRedirect($this->getUrl($url), ['secure'=> true]);
        }
    }
    /**
     * Get RefererURL
     */
    public function getRefererUrl()
    {
        return $this->helper->getRefererUrl();
    }
}
