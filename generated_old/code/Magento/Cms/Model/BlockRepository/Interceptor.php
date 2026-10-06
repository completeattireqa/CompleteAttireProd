<?php
namespace Magento\Cms\Model\BlockRepository;

/**
 * Interceptor class for @see \Magento\Cms\Model\BlockRepository
 */
class Interceptor extends \Magento\Cms\Model\BlockRepository implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Cms\Model\ResourceModel\Block $resource, \Magento\Cms\Model\BlockFactory $blockFactory, \Magento\Cms\Api\Data\BlockInterfaceFactory $dataBlockFactory, \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockCollectionFactory, \Magento\Cms\Api\Data\BlockSearchResultsInterfaceFactory $searchResultsFactory, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor = null)
    {
        $this->___init();
        parent::__construct($resource, $blockFactory, $dataBlockFactory, $blockCollectionFactory, $searchResultsFactory, $dataObjectHelper, $dataObjectProcessor, $storeManager, $collectionProcessor);
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Magento\Cms\Api\Data\BlockInterface $block)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'save');
        if (!$pluginInfo) {
            return parent::save($block);
        } else {
            return $this->___callPlugins('save', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getById($blockId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getById');
        if (!$pluginInfo) {
            return parent::getById($blockId);
        } else {
            return $this->___callPlugins('getById', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getList');
        if (!$pluginInfo) {
            return parent::getList($criteria);
        } else {
            return $this->___callPlugins('getList', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Magento\Cms\Api\Data\BlockInterface $block)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'delete');
        if (!$pluginInfo) {
            return parent::delete($block);
        } else {
            return $this->___callPlugins('delete', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($blockId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'deleteById');
        if (!$pluginInfo) {
            return parent::deleteById($blockId);
        } else {
            return $this->___callPlugins('deleteById', func_get_args(), $pluginInfo);
        }
    }
}
