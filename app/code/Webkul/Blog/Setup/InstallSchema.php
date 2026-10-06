<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        /**
         * Create table 'wk_blog'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_blog'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn(
                'category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => true,'nullable' => false],
                'CategoryId'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => true,'nullable' => false],
                'UserId'
            )
            ->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'CustomerName'
            )
            ->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'CustomerEmail'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Create At'
            )
            ->addColumn(
                'subject',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Subject'
            )
            ->addColumn(
                'content',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '8m',
                ['nullable' => false],
                'Content'
            )
            ->addColumn(
                'preview',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '8m',
                ['nullable' => false],
                'preview'
            )
            ->addColumn(
                'metadescription',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Metadescription'
            )
            ->addColumn(
                'metakeywords',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Metakeywords'
            )
            ->addColumn(
                'tag',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Tag'
            )
            ->addColumn(
                'blog_status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                2,
                ['nullable' => false],
                'BlogStatus'
            )

            ->setComment('Blog Main Table');
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'wk_category'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_category'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn(
                'category',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Category'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Created At'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                2,
                [],
                'Status'
            )
            ->setComment('Blog Category Table');
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'wk_postcomment'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_postcomment'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn(
                'post_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => true,'nullable' => false],
                'PostId'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => true,'nullable' => false],
                'UserId'
            )
            ->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false],
                'CustomerName'
            )
            ->addColumn(
                'customer_website',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'CustomerWebsite'
            )
            ->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'CustomerEmail'
            )
            ->addColumn(
                'comment',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Comment'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                2,
                ['nullable' => false],
                'Status'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Created At'
            )
            ->setComment('Blog Post Comment Table');
        $installer->getConnection()->createTable($table);

              /**
         * Create table 'wk_blogcustomer'
         */
       
         $table = $installer->getConnection()
             ->newTable($installer->getTable('wk_blogcustomer'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => true,'nullable' => false],
                'UserId'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Created At'
            )
            ->addColumn(
                'customer_status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                2,
                ['nullable' => false],
                'Customer Status'
            )
             ->setComment('Blog Customer Table');
         $installer->getConnection()->createTable($table);

         $installer->endSetup();
    }
}
