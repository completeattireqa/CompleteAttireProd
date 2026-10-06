<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MarketplaceBaseShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
 
namespace Webkul\MarketplaceBaseShipping\Setup;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Webkul\Marketplace\Model\ControllersRepository;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    const ATTRIBUTE_CODE_LENGTH = 'ts_dimensions_length';
    const ATTRIBUTE_CODE_WIDTH = 'ts_dimensions_width';
    const ATTRIBUTE_CODE_HEIGHT = 'ts_dimensions_height';
    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @var ControllersRepository
     */
    private $controllersRepository;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory  $attributeSetFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ControllersRepository $controllersRepository
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->controllersRepository = $controllersRepository;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        /**
         * insert sellerstorepickup controller's data
         */
        $data = [];

        if (!count($this->controllersRepository->getByPath('baseshipping/shipping'))) {
            $data[] = [
                'module_name' => 'Webkul_MarketplaceBaseShipping',
                'controller_path' => 'baseshipping/shipping',
                'label' => 'Shipping Setting',
                'is_child' => '0',
                'parent_id' => '0',
            ];
        }
        $setup->getConnection()
            ->insertMultiple($setup->getTable('marketplace_controller_list'), $data);

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(Product::ENTITY, self::ATTRIBUTE_CODE_LENGTH, [
            'type' => 'decimal',
            'label' => 'Length',
            'input' => 'text',
            'required' => false,
            'class' => 'not-negative-amount',
            'sort_order' => 65,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'user_defined' => false,
            'apply_to' => Type::TYPE_SIMPLE
        ]);

        $eavSetup->addAttribute(Product::ENTITY, self::ATTRIBUTE_CODE_WIDTH, [
            'type' => 'decimal',
            'label' => 'Width',
            'input' => 'text',
            'required' => false,
            'class' => 'not-negative-amount',
            'sort_order' => 66,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'user_defined' => false,
            'apply_to' => Type::TYPE_SIMPLE
        ]);

        $eavSetup->addAttribute(Product::ENTITY, self::ATTRIBUTE_CODE_HEIGHT, [
            'type' => 'decimal',
            'label' => 'Height',
            'input' => 'text',
            'required' => false,
            'class' => 'not-negative-amount',
            'sort_order' => 67,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'user_defined' => false,
            'apply_to' => Type::TYPE_SIMPLE
        ]);

        $setup->endSetup();
    }
}
