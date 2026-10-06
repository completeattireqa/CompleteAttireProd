<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_EmailUnsubscribe
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\EmailUnsubscribe\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Unsubscribe extends \Magento\Framework\App\Action\Action
{
    /**
     * @param Context                        $context
     * @param PageFactory                    $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
