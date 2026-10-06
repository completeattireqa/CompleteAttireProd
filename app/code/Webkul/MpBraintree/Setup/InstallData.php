<?php
/**
 * @category   Webkul
 * @package    Webkul_MpBraintree
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Setup;
 
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
 
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;

     /**
      * @var CustomerSetupFactory
      */
    protected $_customerSetupFactory;
    
    /**
     * @var AttributeSetFactory
     */
    private $_attributeSetFactory;
 
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_customerSetupFactory = $customerSetupFactory;
        $this->_attributeSetFactory = $attributeSetFactory;
    }
 
    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {

        $setup->startSetup();
        /**
         * insert marketplace controller's data
         */
        $data = [
            [
                'module_name' => 'Webkul_MpBraintree',
                'controller_path' => 'mpbraintree/braintreeaccount/index',
                'label' => 'Braintree Vendor Details',
                'is_child' => '0',
                'parent_id' => '0',
            ]
        ];

        $setup->getConnection()
            ->insertMultiple($setup->getTable('marketplace_controller_list'), $data);

        $setup->endSetup();

        $attributesArray = [];
        $attrCode = 'braintree_submerchant_id';
        $attributesArray[] = $attrCode;
        $attrLabel = 'Sub Merchant Id';
        $attrNote = 'Braintree sub merchant id for seller';
        /** @var EavSetup $eavSetup */
        
        $eavSetup = $this->_customerSetupFactory->create(['setup' => $setup]);
       // $eavSetup->removeAttribute(Customer::ENTITY, 'mpbraintree_merchant_id');
        $attrCodeExist = $eavSetup->getAttributeId(Customer::ENTITY, $attrCode);
        if ($attrCodeExist === false) {
            $customerEntity = $eavSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();
            
            /** @var $attributeSet AttributeSet */
            $attributeSet = $this->_attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
            $eavSetup->addAttribute(
                Customer::ENTITY,
                $attrCode,
                [
                    'type'              => 'varchar',
                    'label'             => $attrLabel,
                    'input'             => 'text',
                    'frontend_class'    => '',
                    'system'            => false,
                    'global'            => true,
                    'visible'           => false,
                    'required'          => false,
                    'user_defined'      => true,
                    'default'           => '',
                    'note'              => $attrNote
                ]
            );


            //attributte for sub merchant approval status
            $attrCode = 'sub_merchant_status';
            $attributesArray[] = $attrCode;
            $attrLabel = 'Sub Merchant approval status';
            $attrNote = 'confirmation of attribute approval';
            //$eavSetup->removeAttribute(Customer::ENTITY, 'mpbraintree_merchant_id');
            $attrCodeExist = $eavSetup->getAttributeId(Customer::ENTITY, $attrCode);
            if ($attrCodeExist === false) {
                $customerEntity = $eavSetup->getEavConfig()->getEntityType('customer');
                $attributeSetId = $customerEntity->getDefaultAttributeSetId();
                
                /** @var $attributeSet AttributeSet */
                $attributeSet = $this->_attributeSetFactory->create();
                $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
                $eavSetup->addAttribute(
                    Customer::ENTITY,
                    $attrCode,
                    [
                        'type'              => 'int',
                        'label'             => $attrLabel,
                        'input'             => 'select',
                        'source'             => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                        'frontend_class'    => '',
                        'system'            => false,
                        'global'            => true,
                        'visible'           => false,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '',
                        'note'              => $attrNote
                    ]
                );

                foreach ($attributesArray as $ar) {
                    $attribute = $eavSetup->getEavConfig()
                    ->getAttribute(
                        Customer::ENTITY,
                        $ar
                    )
                    ->addData(
                        [
                            'attribute_set_id' => $attributeSetId,
                            'attribute_group_id' => $attributeGroupId,
                            'used_in_forms' => [
                                'adminhtml_customer'
                            ]
                        ]
                    );
                    $attribute->save();
                }
            }
        }
    }
}
