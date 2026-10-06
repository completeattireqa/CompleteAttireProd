<?php

namespace Webkul\ChatGPT\Plugin;

use Webkul\ChatGPT\Helper\Data;
use Webkul\ChatGPT\Ui\Component\MassAction\ImportContent\Stores;

class MassAction extends \Magento\Ui\Component\MassAction
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Stores
     */
    protected $stores;
    
    /**
     * Constructor
     *
     * @param Data $helper
     * @param Stores $stores
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param array $components
     * @param array $data
     */
    public function __construct(
        Data $helper,
        Stores $stores,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        $components,
        array $data
    ) {
        $this->helper = $helper;
        $this->stores = $stores;
        parent::__construct($context, $components, $data);
    }
    /**
     * Prepare
     */
    public function prepare()
    {
        parent::prepare();
        $moduleConfig = $this->helper->getIsChatGPTEnable(0);

        if (!$moduleConfig || $this->stores->jsonSerialize() == null) {
            $allowedActions = [];
            $config = $this->getConfiguration();
            foreach ($config['actions'] as $action) {
                if ($action['type']!='chatgpt') {
                    $allowedActions[] = $action;
                }
            }
            $config['actions']=$allowedActions;
            $this->setData('config', (array)$config);
        }
    }
}
