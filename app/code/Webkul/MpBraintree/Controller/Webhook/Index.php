<?php
/**
 * Webkul Software.
 *
 * @category Webkul
 *
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MpBraintree\Controller\Webhook;

class Index extends \Webkul\MpBraintree\Controller\AbstractController
{

    /**
     * for handling braintree web hooks
     *
     * @return void
     */
    public function execute()
    {

        $postData = $this->getRequest()->getPostValue();
        $this->_webhookManager->parseHooksData($postData);
    }
}
