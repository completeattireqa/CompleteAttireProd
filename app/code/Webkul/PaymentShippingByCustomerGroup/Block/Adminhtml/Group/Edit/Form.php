<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PaymentShippingByCustomerGroup
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PaymentShippingByCustomerGroup\Block\Adminhtml\Group\Edit;

use Magento\Customer\Controller\RegistryConstants;

class Form extends \Magento\Customer\Block\Adminhtml\Group\Edit\Form
{
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Tax\Model\TaxClass\Source\Customer $taxCustomer
     * @param \Magento\Tax\Helper\Data $taxHelper
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     * @param \Magento\Customer\Api\Data\GroupInterfaceFactory $groupDataFactory
     * @param \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\ActivePayments $payments
     * @param \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\ActiveShippings $shippings
     * @param \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\AllSpecificShipping $specificshippings
     * @param \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\AllSpecificPayment $specificpayments
     * @param array $data
     * @param \Magento\Customer\Model\GroupFactory $customerGroup
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Tax\Model\TaxClass\Source\Customer $taxCustomer,
        \Magento\Tax\Helper\Data $taxHelper,
        \Magento\Customer\Model\GroupFactory $customerGroup,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Customer\Api\Data\GroupInterfaceFactory $groupDataFactory,
        \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\ActivePayments $payments,
        \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\ActiveShippings $shippings,
        \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\AllSpecificShipping $specificshippings,
        \Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\AllSpecificPayment $specificpayments,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $taxCustomer,
            $taxHelper,
            $groupRepository,
            $groupDataFactory,
            $data
        );
        $this->shippings = $shippings;
        $this->payments = $payments;
        $this->specificshippings = $specificshippings;
        $this->specificpayments = $specificpayments;
        $this->customerGroup = $customerGroup;
    }

    /**
     * Prepare form for render
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $groupId = $this->_coreRegistry->registry(RegistryConstants::CURRENT_GROUP_ID);
        /** @var \Magento\Customer\Api\Data\GroupInterface $customerGroup */
        if ($groupId === null) {
            $customerGroup = $this->groupDataFactory->create();
            $defaultCustomerTaxClass = $this->_taxHelper->getDefaultCustomerTaxClass();
        } else {
            $customerGroup = $this->_groupRepository->getById($groupId);
            $defaultCustomerTaxClass = $customerGroup->getTaxClassId();
        }
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Group Information')]);
        $validateClass = sprintf(
            'required-entry validate-length maximum-length-%d',
            \Magento\Customer\Model\GroupManagement::GROUP_CODE_MAX_LENGTH
        );
        $name = $fieldset->addField(
            'customer_group_code',
            'text',
            [
                'name' => 'code',
                'label' => __('Group Name'),
                'title' => __('Group Name'),
                'note' => __(
                    'Maximum length must be less then %1 characters.',
                    \Magento\Customer\Model\GroupManagement::GROUP_CODE_MAX_LENGTH
                ),
                'class' => $validateClass,
                'required' => true
            ]
        );
        if ($customerGroup->getId() == 0 && $customerGroup->getCode()) {
            $name->setDisabled(true);
        }
        $fieldset->addField(
            'tax_class_id',
            'select',
            [
                'name' => 'tax_class',
                'label' => __('Tax Class'),
                'title' => __('Tax Class'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->_taxCustomer->toOptionArray(),
            ]
        );
        if ($customerGroup->getId() !== null) {
            // If edit add id
            $form->addField('id', 'hidden', ['name' => 'id', 'value' => $customerGroup->getId()]);
        }
        $fieldset->addField(
            'shipping_methods',
            'multiselect',
            [
                'name' => 'available_shippings',
                'label' => __('Shipping Methods'),
                'title' => __('Shipping Methods'),
                'required' => false,
                'values' => $this->shippings->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'payment_methods',
            'multiselect',
            [
                'name' => 'available_payments',
                'label' => __('Payment Methods'),
                'title' => __('Payment Methods'),
                'required' => false,
                'values' => $this->payments->toOptionArray(),
            ]
        );
        $groupData = $this->customerGroup->create()->load($customerGroup->getId());
        if ($this->_backendSession->getCustomerGroupData()) {
            $form->addValues($this->_backendSession->getCustomerGroupData());
            $this->_backendSession->setCustomerGroupData(null);
        } else {
            $form->addValues(
                [
                    'id' => $customerGroup->getId(),
                    'customer_group_code' => $customerGroup->getCode(),
                    'tax_class_id' => $defaultCustomerTaxClass,
                    'shipping_methods' => $groupData->getShippingMethods(),
                    'payment_methods' => $groupData->getPaymentMethods()
                ]
            );
        }
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('customer/*/save'));
        $form->setMethod('post');
        $this->setForm($form);
    }
}
