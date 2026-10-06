<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Webmull\AffiliateProduct\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
 
class UpgradeData implements UpgradeDataInterface//InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;
 
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory,CategorySetupFactory $categorySetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }
 
    /**
     * {@inheritdoc}
     */
    //public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if ($context->getVersion()
            && version_compare($context->getVersion(), '2.0.4') < 0
        ) {
        /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'affiliate_brand_image',
                [
                    'type' => 'varchar',
                    'backend' => 'Webmull\AffiliateProduct\Model\Attribute\Product\Image',
                    'frontend' => '',
                    'label' => 'Affiliate Brand Image',
                    'input' => 'image',
                    'class' => '',
                    'source' => '',
                    'group' =>'Affiliate Product Link',
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => 0,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => true,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => 'magecomp_affiliate'
                ]
            );
        }

    }
}