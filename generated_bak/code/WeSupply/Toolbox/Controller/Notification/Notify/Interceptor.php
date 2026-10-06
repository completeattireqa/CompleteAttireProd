<?php
namespace WeSupply\Toolbox\Controller\Notification\Notify;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Notification\Notify
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Notification\Notify implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \WeSupply\Toolbox\Helper\Data $helper, \WeSupply\Toolbox\Helper\PhoneCodes $phoneCodes, \WeSupply\Toolbox\Api\WeSupplyApiInterface $weSupplyApi, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory)
    {
        $this->___init();
        parent::__construct($context, $helper, $phoneCodes, $weSupplyApi, $jsonFactory);
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
