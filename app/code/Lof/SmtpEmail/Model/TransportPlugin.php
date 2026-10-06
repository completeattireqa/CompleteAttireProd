<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_Blog
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SmtpEmail\Model;

class TransportPlugin extends \Zend_Mail_Transport_Smtp
{
    /**
     * @var \Magento\Framework\Mail\MessageInterface
     */

    protected $_emaillog;

    protected $_emaildebug;

    protected $_helper; 

    protected $_logger;

    protected $sender_email;
    /**
     * @var \Lof\SmtpEmail\Model\Store
     */
    protected $storeModel;

    public function __construct(
        \Lof\SmtpEmail\Model\Store $storeModel,
        \Lof\SmtpEmail\Helper\Data $dataHelper,
        \Lof\SmtpEmail\Logger\Logger $logger,
        \Lof\SmtpEmail\Model\Emaillog $emaillog,
        \Lof\SmtpEmail\Model\Emaildebug $emaildebug
    ) {
        $this->_helper = $dataHelper;
        $this->_emaillog = $emaillog;
        $this->_emaildebug = $emaildebug;
        $this->_logger = $logger;
        $this->storeModel = $storeModel;
    }
    /**
     * @param \Magento\Framework\Mail\TransportInterface $subject
     * @param \Closure $proceed
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Zend_Mail_Exception
     */
    public function aroundSendMessage(
        \Magento\Framework\Mail\TransportInterface $subject,
        \Closure $proceed
    ) {
        if ($this->_helper->getConfig('general_settings/enable_smtp_email') == 1) {
            if (method_exists($subject, 'getStoreId')) {
                $this->storeModel->setStoreId($subject->getStoreId());
            }
            $message = $subject->getMessage();
            $this->sendSmtpMessage($message);
        } else {
            $proceed();
        }
    }
    /**
     * @param \Magento\Framework\Mail\MessageInterface $message
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Zend_Mail_Exception
     */
    public function sendSmtpMessage(\Magento\Framework\Mail\MessageInterface $message)
    {
        $dataHelper = $this->_helper;
        $dataHelper->setStoreId($this->storeModel->getStoreId());
        if ($message instanceof \Zend_mail) {
            if ($message->getDate() === null) {
                $message->setDate();
            }
        }
        $from = $message->getFrom();
        if($dataHelper->getConfig('trans_email/same_smtp') == 0) {
            if($from == $dataHelper->getConfig('trans_email/general_contact_email')) {
                $username = $dataHelper->getConfig('trans_email/general_contact_email');
                $password = $dataHelper->getConfig('trans_email/general_contact_pass');
            }elseif ($from == $dataHelper->getConfig('trans_email/sales_representative_email')) {
                $username = $dataHelper->getConfig('trans_email/sales_representative_email');
                $password = $dataHelper->getConfig('trans_email/sales_representative_pass');
            }elseif ($from == $dataHelper->getConfig('trans_email/customer_support_email')) {
                $username = $dataHelper->getConfig('trans_email/customer_support_email');
                $password = $dataHelper->getConfig('trans_email/customer_support_pass');
            }elseif ($from == $dataHelper->getConfig('trans_email/custom_email_1_email')) {
                $username = $dataHelper->getConfig('trans_email/custom_email_1_email');
                $password = $dataHelper->getConfig('trans_email/custom_email_1_pass');
            }elseif ($from == $dataHelper->getConfig('trans_email/custom_email_2_email')) {
                $username = $dataHelper->getConfig('trans_email/custom_email_2_email');
                $password = $dataHelper->getConfig('trans_email/custom_email_2_pass');
            }else {
                $username = $dataHelper->getConfigUsername();
                $password = $dataHelper->getConfigPassword();
            }
        } else {
            $username = $dataHelper->getConfigUsername();
            $password = $dataHelper->getConfigPassword();
        }
        $this->sender_email = $username;
        //set config
        $smtpConf = [
            //'name' => $username,
            'port' => $dataHelper->getConfigPort(),
        ];
        $auth = strtolower($dataHelper->getConfigAuth());
        if ($auth != 'none') {
            $smtpConf['auth'] = $auth;
            $smtpConf['username'] = $username;
            $smtpConf['password'] = $password;
        }
        $ssl = $dataHelper->getConfigSsl();
        if ($ssl != 'none') {
            $smtpConf['ssl'] = $ssl;
        }
        $smtpHost = $dataHelper->getConfigSmtpHost();
        $this->initialize($smtpHost, $smtpConf);
        $this->_logger->addDebug($this->_emaillog->isBlacklist($message));
        $this->_emaildebug->messageDebug(__('Ready to send email'));
        if($this->_helper->getConfig('general_settings/enable_smtp_email') == 1) {

            try {
                if($this->_helper->getConfig('general_settings/enable_email_log') == 1) {

                    $emaillogId = $this->_emaillog->messageLog($message,$this->sender_email);

                    if($this->_emaillog->isBlacklist($message)) {
                        $this->_emaildebug->messageDebug(__('Email sent blacklist'));
                        $this->_emaillog->updateStatus($emaillogId,Emaillog::STATUS_BLACKLIST);
                    } elseif($this->_emaillog->isBlockip()){
                        $this->_emaildebug->messageDebug(__('Your email block ip'));
                        $this->_emaillog->updateStatus($emaillogId,Emaillog::STATUS_BLOCKIP);
                    } else {
                        if($this->_emaillog->checkSpam($message)) {
                            $this->_emaildebug->messageDebug(__('Your email is spam'));
                            $this->_emaillog->updateStatus($emaillogId,Emaillog::STATUS_SPAM);
                        } else {
                            parent::send($message);
                            $this->_emaildebug->messageDebug(__('Email sent successfully'));
                            $this->_emaillog->updateStatus($emaillogId,Emaillog::STATUS_SENT);
                        }
                    } 
                } else {
                    parent::send($message);
                    $this->_emaildebug->messageDebug(__('Email sent successfully'));
                }  
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\MailException(new \Magento\Framework\Phrase($e->getMessage()), $e);
            }
        }
    }
    /**
     * @param string $host
     * @param array $config
     */
    public function initialize($host = '127.0.0.1', array $config = [])
    {
        if (isset($config['name'])) {
            $this->_name = $config['name'];
        }
        if (isset($config['port'])) {
            $this->_port = $config['port'];
        }
        if (isset($config['auth'])) {
            $this->_auth = $config['auth'];
        }
        $this->_host = $host;
        $this->_config = $config;
    }
}