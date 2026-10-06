<?php
namespace WeltPixel\SocialLogin\Block\Widget\Login;

/**
 * Interceptor class for @see \WeltPixel\SocialLogin\Block\Widget\Login
 */
class Interceptor extends \WeltPixel\SocialLogin\Block\Widget\Login implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \WeltPixel\SocialLogin\Helper\Data $slHelper, \WeltPixel\SocialLogin\Model\Twitter $twitterModel, \WeltPixel\SocialLogin\Model\Paypal $paypalModel, \Magento\Framework\App\Request\Http $request, \Magento\Framework\Data\Form\FormKey $formKey, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Model\Url $customerUrl, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $slHelper, $twitterModel, $paypalModel, $request, $formKey, $customerSession, $customerUrl, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerLoginUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCustomerLoginUrl');
        if (!$pluginInfo) {
            return parent::getCustomerLoginUrl();
        } else {
            return $this->___callPlugins('getCustomerLoginUrl', func_get_args(), $pluginInfo);
        }
    }
}
