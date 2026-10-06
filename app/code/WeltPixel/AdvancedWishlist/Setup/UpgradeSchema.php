<?php

namespace WeltPixel\AdvancedWishlist\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $tableName = 'wishlist';

            $installer->getConnection()->addColumn(
                $installer->getTable($tableName),
                'disable_share',
                [
                    'type' => Table::TYPE_BOOLEAN,
                    'nullable' => false,
                    'default' => '0',
                    'comment' => 'Disable Share'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0) {

            $tableName = 'wishlist';

            $installer->getConnection()->addColumn(
                $installer->getTable($tableName),
                'disable_price_alert',
                [
                    'type' => Table::TYPE_BOOLEAN,
                    'nullable' => false,
                    'default' => '0',
                    'comment' => 'Disable Price Alert'
                ]
            );

            $tableName = 'wishlist_product_alert_price';

            $table = $installer->getConnection()->newTable(
                $tableName
            )->addColumn(
                'alert_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Alert Id'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Customer id'
            )->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Product id'
            )->addColumn(
                'price',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12,4',
                ['nullable' => false, 'default' => '0.0000'],
                'Price amount'
            )->addColumn(
                'website_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Website id'
            )->addColumn(
                'wishlist_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Wishlist id'
            )->addIndex(
                $installer->getIdxName($tableName, ['customer_id']),
                ['customer_id']
            )->addIndex(
                $installer->getIdxName($tableName, ['product_id']),
                ['product_id']
            )->addIndex(
                $installer->getIdxName($tableName, ['website_id']),
                ['website_id']
            )->addIndex(
                $installer->getIdxName($tableName, ['wishlist_id']),
                ['wishlist_id']
            )->addForeignKey(
                $installer->getFkName($tableName, 'customer_id', 'customer_entity', 'entity_id'),
                'customer_id',
                $installer->getTable('customer_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName($tableName, 'product_id', 'catalog_product_entity', 'entity_id'),
                'product_id',
                $installer->getTable('catalog_product_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName($tableName, 'website_id', 'store_website', 'website_id'),
                'website_id',
                $installer->getTable('store_website'),
                'website_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName($tableName, 'wishlist_id', 'wishlist', 'wishlist_id'),
                'wishlist_id',
                $installer->getTable('wishlist'),
                'wishlist_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'Wishlist Product Alert Price'
            );

            $installer->getConnection()->createTable($table);
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $tableName = 'wishlist';

            $installer->getConnection()->addColumn(
                $installer->getTable($tableName),
                'disable_public',
                [
                    'type' => Table::TYPE_BOOLEAN,
                    'nullable' => false,
                    'default' => '0',
                    'comment' => 'Disable Public'
                ]
            );
        }

        $installer->endSetup();
    }
}