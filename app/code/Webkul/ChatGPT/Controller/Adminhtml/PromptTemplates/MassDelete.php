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
namespace Webkul\ChatGPT\Controller\Adminhtml\PromptTemplates;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Webkul\ChatGPT\Model\ResourceModel\PromptTemplates\CollectionFactory;

class MassDelete extends Action
{
    /**
     * @var $collectionFactory
     */
    public $collectionFactory;
    /**
     * @var $filter
     */
    public $filter;
    /**
     * @var $promptTemplatesFactory
     */
    public $promptTemplatesFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplatesFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplatesFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->promptTemplatesFactory = $promptTemplatesFactory;
        parent::__construct($context);
    }
    /**
     * Execute
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());

            $count = 0;
            foreach ($collection as $model) {
                $model = $this->promptTemplatesFactory->create()->load($model->getEntityId());
                $model->delete();
                $count++;
            }
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
    /**
     * Is allowed
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_ChatGPT::prompt_templates');
    }
}
