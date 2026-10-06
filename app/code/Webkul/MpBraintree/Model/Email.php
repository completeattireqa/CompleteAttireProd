<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MpBraintree\Model;

use Magento\Customer\Model\Session;
use Magento\Framework\Exception\MailException;

class Email extends \Webkul\Marketplace\Helper\Email
{

    const XML_PATH_EMAIL_SELLER_BANK_TRANSFER = 'marketplace/mpbraintree/email_seller_bank_transfer_template';
    const XML_PATH_CRON_EMAIL = 'marketplace/mpbraintree/email_cron_template';

    public function sendSellerDeclineMail($emailTemplateVariables, $receiverInfo)
    {
        $helper = $this->_objectManager->get(
            'Webkul\Marketplace\Helper\Data'
        );

        $adminStoremail = $helper->getAdminEmailId();
        $adminEmail=$adminStoremail? $adminStoremail:$helper->getDefaultTransEmailId();
        $adminUsername = 'Admin';
        $senderInfo['name'] = $adminUsername;
        $senderInfo['email'] = $adminEmail;
        
        $this->sendSellerDisapproveMail($emailTemplateVariables, $senderInfo, $receiverInfo);
    }

    public function sendBankTransferEmail($emailTemplateVariables, $receiverInfo)
    {
        $helper = $this->_objectManager->get(
            'Webkul\Marketplace\Helper\Data'
        );

        $adminStoremail = $helper->getAdminEmailId();
        $adminEmail=$adminStoremail? $adminStoremail:$helper->getDefaultTransEmailId();
        $adminUsername = 'Admin';
        $senderInfo['name'] = $adminUsername;
        $senderInfo['email'] = $adminEmail;
        $this->_template = $this->getTemplateId(self::XML_PATH_EMAIL_SELLER_BANK_TRANSFER);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        try {
            $transport = $this->_transportBuilder->getTransport();
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->_messageManager->addError($e->getMessage());
        }
        $this->_inlineTranslation->resume();
    }

    public function cronNotification($emailTemplateVariables, $receiverInfo)
    {
    }
}
