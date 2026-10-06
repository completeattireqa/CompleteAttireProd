<?php
namespace Magento\Catalog\Ui\DataProvider\CatalogEavValidationRules;

/**
 * Interceptor class for @see \Magento\Catalog\Ui\DataProvider\CatalogEavValidationRules
 */
class Interceptor extends \Magento\Catalog\Ui\DataProvider\CatalogEavValidationRules implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function build(\Magento\Catalog\Api\Data\ProductAttributeInterface $attribute, array $data)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'build');
        if (!$pluginInfo) {
            return parent::build($attribute, $data);
        } else {
            return $this->___callPlugins('build', func_get_args(), $pluginInfo);
        }
    }
}
