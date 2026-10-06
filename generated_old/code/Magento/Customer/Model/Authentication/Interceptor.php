<?php
namespace Magento\Customer\Model\Authentication;

/**
 * Interceptor class for @see \Magento\Customer\Model\Authentication
 */
class Interceptor extends \Magento\Customer\Model\Authentication implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Customer\Model\CustomerRegistry $customerRegistry, \Magento\Backend\App\ConfigInterface $backendConfig, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Framework\Encryption\EncryptorInterface $encryptor)
    {
        $this->___init();
        parent::__construct($customerRepository, $customerRegistry, $backendConfig, $dateTime, $encryptor);
    }

    /**
     * {@inheritdoc}
     */
    public function processAuthenticationFailure($customerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'processAuthenticationFailure');
        if (!$pluginInfo) {
            return parent::processAuthenticationFailure($customerId);
        } else {
            return $this->___callPlugins('processAuthenticationFailure', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function unlock($customerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'unlock');
        if (!$pluginInfo) {
            return parent::unlock($customerId);
        } else {
            return $this->___callPlugins('unlock', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isLocked($customerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isLocked');
        if (!$pluginInfo) {
            return parent::isLocked($customerId);
        } else {
            return $this->___callPlugins('isLocked', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($customerId, $password)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'authenticate');
        if (!$pluginInfo) {
            return parent::authenticate($customerId, $password);
        } else {
            return $this->___callPlugins('authenticate', func_get_args(), $pluginInfo);
        }
    }
}
