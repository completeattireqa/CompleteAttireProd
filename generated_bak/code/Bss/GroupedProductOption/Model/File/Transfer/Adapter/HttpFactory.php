<?php
namespace Bss\GroupedProductOption\Model\File\Transfer\Adapter;

/**
 * Factory class for @see \Bss\GroupedProductOption\Model\File\Transfer\Adapter\Http
 */
class HttpFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Bss\\GroupedProductOption\\Model\\File\\Transfer\\Adapter\\Http')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Bss\GroupedProductOption\Model\File\Transfer\Adapter\Http
     */
    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
