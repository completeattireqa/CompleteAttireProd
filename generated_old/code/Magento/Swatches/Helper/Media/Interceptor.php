<?php
namespace Magento\Swatches\Helper\Media;

/**
 * Interceptor class for @see \Magento\Swatches\Helper\Media
 */
class Interceptor extends \Magento\Swatches\Helper\Media implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\Product\Media\Config $mediaConfig, \Magento\Framework\Filesystem $filesystem, \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageDb, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Image\Factory $imageFactory, \Magento\Theme\Model\ResourceModel\Theme\Collection $themeCollection, \Magento\Framework\View\ConfigInterface $configInterface)
    {
        $this->___init();
        parent::__construct($mediaConfig, $filesystem, $fileStorageDb, $storeManager, $imageFactory, $themeCollection, $configInterface);
    }

    /**
     * {@inheritdoc}
     */
    public function getSwatchAttributeImage($swatchType, $file)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSwatchAttributeImage');
        if (!$pluginInfo) {
            return parent::getSwatchAttributeImage($swatchType, $file);
        } else {
            return $this->___callPlugins('getSwatchAttributeImage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function moveImageFromTmp($file)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'moveImageFromTmp');
        if (!$pluginInfo) {
            return parent::moveImageFromTmp($file);
        } else {
            return $this->___callPlugins('moveImageFromTmp', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generateSwatchVariations($imageUrl)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'generateSwatchVariations');
        if (!$pluginInfo) {
            return parent::generateSwatchVariations($imageUrl);
        } else {
            return $this->___callPlugins('generateSwatchVariations', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFolderNameSize($swatchType, $imageConfig = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFolderNameSize');
        if (!$pluginInfo) {
            return parent::getFolderNameSize($swatchType, $imageConfig);
        } else {
            return $this->___callPlugins('getFolderNameSize', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImageConfig()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImageConfig');
        if (!$pluginInfo) {
            return parent::getImageConfig();
        } else {
            return $this->___callPlugins('getImageConfig', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSwatchMediaUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSwatchMediaUrl');
        if (!$pluginInfo) {
            return parent::getSwatchMediaUrl();
        } else {
            return $this->___callPlugins('getSwatchMediaUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeSwatchPath($file)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAttributeSwatchPath');
        if (!$pluginInfo) {
            return parent::getAttributeSwatchPath($file);
        } else {
            return $this->___callPlugins('getAttributeSwatchPath', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSwatchMediaPath()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSwatchMediaPath');
        if (!$pluginInfo) {
            return parent::getSwatchMediaPath();
        } else {
            return $this->___callPlugins('getSwatchMediaPath', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSwatchCachePath($swatchType)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSwatchCachePath');
        if (!$pluginInfo) {
            return parent::getSwatchCachePath($swatchType);
        } else {
            return $this->___callPlugins('getSwatchCachePath', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isModuleOutputEnabled($moduleName = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isModuleOutputEnabled');
        if (!$pluginInfo) {
            return parent::isModuleOutputEnabled($moduleName);
        } else {
            return $this->___callPlugins('isModuleOutputEnabled', func_get_args(), $pluginInfo);
        }
    }
}
