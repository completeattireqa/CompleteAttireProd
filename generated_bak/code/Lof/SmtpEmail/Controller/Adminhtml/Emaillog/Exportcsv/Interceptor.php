<?php
namespace Lof\SmtpEmail\Controller\Adminhtml\Emaillog\Exportcsv;

/**
 * Interceptor class for @see \Lof\SmtpEmail\Controller\Adminhtml\Emaillog\Exportcsv
 */
class Interceptor extends \Lof\SmtpEmail\Controller\Adminhtml\Emaillog\Exportcsv implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\LayoutInterface $layout, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\App\Response\Http\FileFactory $fileFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $layout, $filesystem, $fileFactory);
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
