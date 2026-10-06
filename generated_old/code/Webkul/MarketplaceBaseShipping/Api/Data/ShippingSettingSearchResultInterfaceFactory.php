<?php
namespace Webkul\MarketplaceBaseShipping\Api\Data;

/**
 * Factory class for @see \Webkul\MarketplaceBaseShipping\Api\Data\ShippingSettingSearchResultInterface
 */
class ShippingSettingSearchResultInterfaceFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Webkul\\MarketplaceBaseShipping\\Api\\Data\\ShippingSettingSearchResultInterface')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Webkul\MarketplaceBaseShipping\Api\Data\ShippingSettingSearchResultInterface
     */
    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
