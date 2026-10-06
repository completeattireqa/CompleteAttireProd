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
namespace Webkul\ChatGPT\Block\Adminhtml\Category\Form;

use Magento\Ui\Component\MassAction\Filter;

class ChatGPT extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Backend\Block\Widget\Context
     */
    private $context;

    /**
     * @var \Webkul\ChatGPT\Helper\Data
     */
    protected $helper;
    
    /**
     * Block template.
     *
     * @var string
     */
    protected $_template = 'chatgpt.phtml';

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Webkul\ChatGPT\Helper\Data $helper
     * @param array $data = []
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\ChatGPT\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    /**
     * Get ChatGPT Helper
     *
     * @return \Webkul\ChatGPT\Helper\Data
     */
    public function getChatGPTHelper()
    {
        return $this->helper;
    }
}
