<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Marketplace
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\Marketplace\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Webkul\Marketplace\Model\ControllersRepository;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * Upgrade Data script
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var ControllersRepository
     */
    private $controllersRepository;
    
    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $_filesystemFile;

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @param ControllersRepository                 $controllersRepository
     * @param \Magento\Framework\Filesystem\Io\File $filesystemFile
     * @param EavSetupFactory                       $eavSetupFactory
     */
    public function __construct(
        ControllersRepository $controllersRepository,
        \Magento\Framework\Filesystem\Io\File $filesystemFile,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->controllersRepository = $controllersRepository;
        $this->_filesystemFile = $filesystemFile;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->moveDirToMediaDir();
        $setup->startSetup();
        /**
         * insert marketplace controller's data
         */
        $data = [];
        

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'content_updated_at',
            [
                'type' => 'datetime',
                'backend' => \Magento\Eav\Model\Entity\Attribute\Backend\Datetime::class,
                'frontend' => '',
                'label' => 'Content Updated At',
                'input' => 'date',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => false,
                'unique' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
            ]
        );

        $setup->endSetup();
    }
}
