<?php

namespace Webkul\ChatGPT\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Config\ConfigOptionsListConstants;
use Magento\Store\Model\ScopeInterface;

class ConfigHelper extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @var DeploymentConfig
     */
    protected $deploymentConfig;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig
    ) {
            $this->scopeConfig = $scopeConfig;
            $this->_resource = $resource;
            $this->storeManager = $storeManager;
            $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * Get Store Config By Section
     *
     * @param mixed $section
     * @param int $storeId = null
     */
    public function getStoreConfigBySection($section, $storeId = null)
    {
        $tablePrefix = $this->deploymentConfig->get(
            ConfigOptionsListConstants::CONFIG_PATH_DB_PREFIX
        );
        $config = [];
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $tablename = $connection->getTableName($tablePrefix.'core_config_data');
        if (!$storeId) {
            $storeId = $this->getStoreId();
        }
        $query = $connection
        ->select('path')
        ->from($tablename)
        ->where("`path` like '%".$section."%'")
        ->where("`scope_id` = '" .$storeId. "'");

        $result = $connection->fetchAll($query);
        if (!count($result)) {
            $config['active'] = $this->scopeConfig->getValue(
                'chatgpt/general_settings/active',
                ScopeInterface::SCOPE_STORE
            );
        }
        foreach ($result as $key => $value) {
            $config[explode('/', $value['path'])[2]]=$value['value'];
        }
        if (!isset($config['active'])) {
            $config['active'] = $this->scopeConfig->getValue(
                'chatgpt/general_settings/active',
                ScopeInterface::SCOPE_STORE
            );
        }

        if (!isset($config['secret'])) {
            $config['secret'] = $this->scopeConfig->getValue(
                'chatgpt/general_settings/secret',
                ScopeInterface::SCOPE_STORE
            );
        }

        if (!isset($config['attributes'])) {
            $config['attributes'] = $this->scopeConfig->getValue(
                'chatgpt/general_settings/attributes',
                ScopeInterface::SCOPE_STORE
            );
        }

        return $config;
    }
    /**
     * Funtion to return store id.
     *
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }
}
