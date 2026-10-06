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
namespace Webkul\ChatGPT\Block\Adminhtml;

use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Data\Form\FormKey;

class PromptTemplates extends \Magento\Framework\View\Element\Template
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
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection
     * @param \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollection
     * @param Filter $filter
     * @param \Webkul\ChatGPT\Helper\Data $helper
     * @param FormKey $formKey
     * @param \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplatesFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollection,
        Filter $filter,
        \Webkul\ChatGPT\Helper\Data $helper,
        FormKey $formKey,
        \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplatesFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->jsonHelper = $jsonHelper;
        $this->filter = $filter;
        $this->helper = $helper;
        $this->productCollection = $productCollection;
        $this->pageCollection = $pageCollection;
        $this->formKey = $formKey;
        $this->promptTemplatesFactory = $promptTemplatesFactory;
    }
    /**
     * Get Categories
     */
    public function getCategories()
    {
        $categories = [];
        $categories['copwri'] = __('Copywriting');
        $categories['market'] = __('Marketing');
        $categories['seenop'] = __('SEO');
        $categories['socmed'] = __('Social Media');
        $categories['produc'] = __('Productivity');
        $categories['occupa'] = __('Professionals');
        return $categories;
    }
    /**
     * Get Form Key
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
    /**
     * Get PromptTemplateData
     */
    public function getPromptTemplateData()
    {
        $templateData = [];
        $templateId = $this->getRequest()->getParam('entity_id');
        if ($templateId) {
            $template = $this->promptTemplatesFactory->create()
            ->getCollection()
            ->addFieldToFilter('entity_id', $templateId)
            ->getFirstItem();
            $templateData['entity_id'] = $template->getEntityId();
            $templateData['template_title'] = $template->getTemplateTitle();
            $templateData['category'] = trim($template->getCategory()??'');
            $templateData['sub_category'] = trim($template->getSubCategory()??'');
            $templateData['templates'] = $template->getTemplates();
            $templateData['section_global'] = $this->helper->getJsonDecode($template->getSectionGlobal()??'', true);
            $templateData['section_inputs'] = $this->helper->getJsonDecode($template->getSectionInputs()??'', true);
            $templateData['prompt'] = $template->getPrompt();
        }
        return $templateData;
    }
    /**
     * Category, SubCategory Data Array
     */
    public function getSubCategories()
    {
        return $this->helper->getSubCategories();
    }
}
