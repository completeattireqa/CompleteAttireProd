<?php

namespace Webkul\ChatGPT\Model\Config\Source;

use Webkul\ChatGPT\Model\PromptTemplates as PromptTemplatesModel;
use Magento\Catalog\Api\Data\ProductAttributeInterface;

class PromptTemplates implements \Magento\Framework\Option\ArrayInterface
{
      /**
       * @var PromptTemplatesModel
       */
    protected $templates;

      /**
       * Constructor
       *
       * @param PromptTemplates $templates
       */
    public function __construct(
        PromptTemplatesModel $templates
    ) {
        $this->templates = $templates;
    }
    /**
     * To Option Array
     */
    public function toOptionArray()
    {
        $options =[];
        $options[] = ['value'=> '','label'=> __("Select ChatGPT Prompt Template")];
        foreach ($this->getTemplateCollection() as $template) {
            $options[]=['value'=>$template->getEntityId(),'label'=>$template->getTemplateTitle()];
        }
        return $options;
    }
    /**
     * Get Attributes Collection
     */
    public function getTemplateCollection()
    {
        return $this->templates->getCollection();
    }
}
