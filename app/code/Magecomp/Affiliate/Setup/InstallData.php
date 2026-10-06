<?php
namespace Magecomp\Affiliate\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
	
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
	
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        //$setup->startSetup();
  		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'allowproductview',
            [
                'group' => 'Affiliate Product Link',
        		'label' => 'Enable Affiliation Link',
				'type'  => 'int',
        		'input' => 'boolean',
        		'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'source' => '',
                'required' => false,
                'sort_order' => 1,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'used_in_product_listing' => true,
                'visible_on_front' => false,
				'apply_to' => 'magecomp_affiliate'
            ]
        );
		
		$eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'linkurl',
            [
                'group' => 'Affiliate Product Link',
        		'label' => 'Link URL',
				'type'  => 'varchar',
        		'input' => 'text',
                'source' => '',
                'required' => false,
                'sort_order' => 2,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'used_in_product_listing' => true,
                'visible_on_front' => false,
				'apply_to' => 'magecomp_affiliate',
				'note' => 'Add URL starting with http:// or https://'
            ]
        );
		
		$eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'linetext',
            [
                'group' => 'Affiliate Product Link',
        		'label' => 'Link Text',
				'type'  => 'varchar',
        		'input' => 'text',
                'source' => '',
                'required' => false,
                'sort_order' => 2,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'used_in_product_listing' => true,
                'visible_on_front' => false,
				'apply_to' => 'magecomp_affiliate'
            ]
        );
		$eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'openin',
            [
                'group' => 'Affiliate Product Link',
        		'label' => 'Open In',
				'type'  => 'varchar',
        		'input' => 'select',
                'source' => 'Magecomp\Affiliate\Model\Entity\Attribute\Source\Openin',
                'required' => false,
                'sort_order' => 3,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'used_in_product_listing' => true,
                'visible_on_front' => false,
				'apply_to' => 'magecomp_affiliate'
            ]
        );
		// Price Attribute set in Affiliate Product Type
		  $fieldList = [
			  'price',
			  'special_price',
			  'special_from_date',
			  'special_to_date',
			  'minimal_price',
			  'cost',
			  'tier_price',
		  ];
		  foreach ($fieldList as $field) {
			  $applyTo = explode(
				  ',',
				  $eavSetup->getAttribute(\Magento\Catalog\Model\Product::ENTITY, $field, 'apply_to')
			  );
			  if (!in_array('magecomp_affiliate', $applyTo)) {
				  $applyTo[] = 'magecomp_affiliate';
				  $eavSetup->updateAttribute(
					  \Magento\Catalog\Model\Product::ENTITY,
					  $field,
					  'apply_to',
					  implode(',', $applyTo)
				  );
			  }
		  }
		$setup->endSetup();
    }
}