<?php
namespace Magento\Catalog\Model\Product\Option\Type\File\ValidatorFile;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Option\Type\File\ValidatorFile
 */
class Interceptor extends \Magento\Catalog\Model\Product\Option\Type\File\ValidatorFile implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\File\Size $fileSize, \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory, \Magento\Framework\Validator\File\IsImage $isImageValidator)
    {
        $this->___init();
        parent::__construct($scopeConfig, $filesystem, $fileSize, $httpFactory, $isImageValidator);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($processingParams, $option)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validate');
        if (!$pluginInfo) {
            return parent::validate($processingParams, $option);
        } else {
            return $this->___callPlugins('validate', func_get_args(), $pluginInfo);
        }
    }
}
