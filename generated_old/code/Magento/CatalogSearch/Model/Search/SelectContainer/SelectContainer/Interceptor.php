<?php
namespace Magento\CatalogSearch\Model\Search\SelectContainer\SelectContainer;

/**
 * Interceptor class for @see \Magento\CatalogSearch\Model\Search\SelectContainer\SelectContainer
 */
class Interceptor extends \Magento\CatalogSearch\Model\Search\SelectContainer\SelectContainer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\DB\Select $select, array $nonCustomAttributesFilters, array $customAttributesFilters, array $dimensions, bool $isFullTextSearchRequired, bool $isShowOutOfStockEnabled, $usedIndex, \Magento\Framework\Search\Request\FilterInterface $visibilityFilter = null)
    {
        $this->___init();
        parent::__construct($select, $nonCustomAttributesFilters, $customAttributesFilters, $dimensions, $isFullTextSearchRequired, $isShowOutOfStockEnabled, $usedIndex, $visibilityFilter);
    }

    /**
     * {@inheritdoc}
     */
    public function getNonCustomAttributesFilters()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getNonCustomAttributesFilters');
        if (!$pluginInfo) {
            return parent::getNonCustomAttributesFilters();
        } else {
            return $this->___callPlugins('getNonCustomAttributesFilters', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomAttributesFilters()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCustomAttributesFilters');
        if (!$pluginInfo) {
            return parent::getCustomAttributesFilters();
        } else {
            return $this->___callPlugins('getCustomAttributesFilters', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasCustomAttributesFilters()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'hasCustomAttributesFilters');
        if (!$pluginInfo) {
            return parent::hasCustomAttributesFilters();
        } else {
            return $this->___callPlugins('hasCustomAttributesFilters', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasVisibilityFilter()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'hasVisibilityFilter');
        if (!$pluginInfo) {
            return parent::hasVisibilityFilter();
        } else {
            return $this->___callPlugins('hasVisibilityFilter', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getVisibilityFilter()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getVisibilityFilter');
        if (!$pluginInfo) {
            return parent::getVisibilityFilter();
        } else {
            return $this->___callPlugins('getVisibilityFilter', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isFullTextSearchRequired()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isFullTextSearchRequired');
        if (!$pluginInfo) {
            return parent::isFullTextSearchRequired();
        } else {
            return $this->___callPlugins('isFullTextSearchRequired', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isShowOutOfStockEnabled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isShowOutOfStockEnabled');
        if (!$pluginInfo) {
            return parent::isShowOutOfStockEnabled();
        } else {
            return $this->___callPlugins('isShowOutOfStockEnabled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUsedIndex()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUsedIndex');
        if (!$pluginInfo) {
            return parent::getUsedIndex();
        } else {
            return $this->___callPlugins('getUsedIndex', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDimensions()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDimensions');
        if (!$pluginInfo) {
            return parent::getDimensions();
        } else {
            return $this->___callPlugins('getDimensions', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSelect()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSelect');
        if (!$pluginInfo) {
            return parent::getSelect();
        } else {
            return $this->___callPlugins('getSelect', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateSelect(\Magento\Framework\DB\Select $select)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'updateSelect');
        if (!$pluginInfo) {
            return parent::updateSelect($select);
        } else {
            return $this->___callPlugins('updateSelect', func_get_args(), $pluginInfo);
        }
    }
}
