<?php

namespace WeltPixel\UserProfile\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'weltpixel_user_profile'
         */
        $tableName = 'weltpixel_user_profile';
        if ($installer->getConnection()->isTableExists($installer->getTable($tableName)) != true) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable($tableName))
                ->addColumn(
                    'profile_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Profile Id'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['unsigned' => true, 'nullable' => false],
                    'Customer Id'
                )
                ->addColumn(
                    'username',
                    Table::TYPE_TEXT,
                    20,
                    ['nullable' => false],
                    'Profile Username'
                )
                ->addColumn(
                    'avatar',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Profile Image'
                )
                ->addColumn(
                    'cover_image',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Profile Cover Image'
                )
                ->addColumn(
                    'first_name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Profile First Name'
                )
                ->addColumn(
                    'last_name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Profile Last Name'
                )
                ->addColumn(
                    'location',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Profile Location'
                )
                ->addColumn(
                    'gender',
                    Table::TYPE_TEXT,
                    32,
                    ['nullable' => true],
                    'Profile Gender'
                )
                ->addColumn(
                    'dob',
                    Table::TYPE_DATE,
                    255,
                    ['nullable' => true],
                    'Profile Date of birth'
                )
                ->addColumn(
                    'bio',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => true],
                    'Profile Bio'
                )
                ->addIndex(
                    $installer->getIdxName(
                        $tableName,
                        ['customer_id'],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['customer_id'],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addIndex(
                    $installer->getIdxName(
                        $tableName,
                        ['username'],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['username'],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addForeignKey(
                    $installer->getFkName($tableName, 'customer_id', 'customer_entity', 'entity_id'),
                    'customer_id',
                    $installer->getTable('customer_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment(
                    'WeltPixel user Profile'
                );

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();

    }
}
