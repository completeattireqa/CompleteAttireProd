<?php
namespace Magento\Framework\View\Asset\PreProcessor\Chain;

/**
 * Interceptor class for @see \Magento\Framework\View\Asset\PreProcessor\Chain
 */
class Interceptor extends \Magento\Framework\View\Asset\PreProcessor\Chain implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Asset\LocalInterface $asset, $origContent, $origContentType, $origAssetPath, array $compatibleTypes = array())
    {
        $this->___init();
        parent::__construct($asset, $origContent, $origContentType, $origAssetPath, $compatibleTypes);
    }

    /**
     * {@inheritdoc}
     */
    public function getAsset()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAsset');
        if (!$pluginInfo) {
            return parent::getAsset();
        } else {
            return $this->___callPlugins('getAsset', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrigContent()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrigContent');
        if (!$pluginInfo) {
            return parent::getOrigContent();
        } else {
            return $this->___callPlugins('getOrigContent', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getContent');
        if (!$pluginInfo) {
            return parent::getContent();
        } else {
            return $this->___callPlugins('getContent', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setContent');
        if (!$pluginInfo) {
            return parent::setContent($content);
        } else {
            return $this->___callPlugins('setContent', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrigContentType()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrigContentType');
        if (!$pluginInfo) {
            return parent::getOrigContentType();
        } else {
            return $this->___callPlugins('getOrigContentType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getContentType');
        if (!$pluginInfo) {
            return parent::getContentType();
        } else {
            return $this->___callPlugins('getContentType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setContentType($contentType)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setContentType');
        if (!$pluginInfo) {
            return parent::setContentType($contentType);
        } else {
            return $this->___callPlugins('setContentType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetContentType()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTargetContentType');
        if (!$pluginInfo) {
            return parent::getTargetContentType();
        } else {
            return $this->___callPlugins('getTargetContentType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetAssetPath()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTargetAssetPath');
        if (!$pluginInfo) {
            return parent::getTargetAssetPath();
        } else {
            return $this->___callPlugins('getTargetAssetPath', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function assertValid()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'assertValid');
        if (!$pluginInfo) {
            return parent::assertValid();
        } else {
            return $this->___callPlugins('assertValid', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isChanged()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isChanged');
        if (!$pluginInfo) {
            return parent::isChanged();
        } else {
            return $this->___callPlugins('isChanged', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrigAssetPath()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrigAssetPath');
        if (!$pluginInfo) {
            return parent::getOrigAssetPath();
        } else {
            return $this->___callPlugins('getOrigAssetPath', func_get_args(), $pluginInfo);
        }
    }
}
