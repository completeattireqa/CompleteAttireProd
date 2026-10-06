<?php
namespace Bss\GroupedProductOption\Block\Product\View\Type\Grouped;

/**
 * Interceptor class for @see \Bss\GroupedProductOption\Block\Product\View\Type\Grouped
 */
class Interceptor extends \Bss\GroupedProductOption\Block\Product\View\Type\Grouped implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Stdlib\ArrayUtils $arrayUtils, \Bss\GroupedProductOption\Helper\Data $helperBss, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Framework\Locale\FormatInterface $localeFormat, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Framework\DataObjectFactory $dataObjectFactory, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $arrayUtils, $helperBss, $productRepository, $localeFormat, $jsonEncoder, $dataObjectFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function isRedirectToCartEnabled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isRedirectToCartEnabled');
        if (!$pluginInfo) {
            return parent::isRedirectToCartEnabled();
        } else {
            return $this->___callPlugins('isRedirectToCartEnabled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = array())
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
