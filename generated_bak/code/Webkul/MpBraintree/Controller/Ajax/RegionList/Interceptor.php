<?php
namespace Webkul\MpBraintree\Controller\Ajax\RegionList;

/**
 * Interceptor class for @see \Webkul\MpBraintree\Controller\Ajax\RegionList
 */
class Interceptor extends \Webkul\MpBraintree\Controller\Ajax\RegionList implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Directory\Model\RegionFactory $regionFactory)
    {
        $this->___init();
        parent::__construct($context, $regionFactory);
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
