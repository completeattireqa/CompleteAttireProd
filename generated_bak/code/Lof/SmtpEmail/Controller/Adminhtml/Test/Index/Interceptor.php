<?php
namespace Lof\SmtpEmail\Controller\Adminhtml\Test\Index;

/**
 * Interceptor class for @see \Lof\SmtpEmail\Controller\Adminhtml\Test\Index
 */
class Interceptor extends \Lof\SmtpEmail\Controller\Adminhtml\Test\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Lof\SmtpEmail\Helper\Data $dataHelper, \Magento\Framework\Mail\MessageInterface $message, \Lof\SmtpEmail\Model\Emaildebug $emaildebug)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $dataHelper, $message, $emaildebug);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
