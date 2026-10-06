<?php
namespace Webkul\MarketplaceBaseShipping\Model\ResourceModel\ShippingSetting;

/**
 * Factory class for @see \Webkul\MarketplaceBaseShipping\Model\ResourceModel\ShippingSetting\Collection
 */
class CollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Webkul\\MarketplaceBaseShipping\\Model\\ResourceModel\\ShippingSetting\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Webkul\MarketplaceBaseShipping\Model\ResourceModel\ShippingSetting\Collection
     */
    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
