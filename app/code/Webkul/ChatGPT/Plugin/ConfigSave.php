<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_ChatGPT
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\ChatGPT\Plugin;

use Webkul\ChatGPT\Helper\Data;
use Webkul\ChatGPT\Ui\Component\MassAction\ImportContent\Stores;
use Magento\Framework\App\Config\Storage\WriterInterface;

class ConfigSave
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Stores
     */
    protected $stores;
    
    /**
     * @var WriterInterface $configWriter
     */
    protected $configWriter;

    /**
     * @var $errors
     */
    protected $errors;

    /**
     * Constructor
     *
     * @param Data $helper
     * @param Stores $stores
     * @param WriterInterface $configWriter
     */
    public function __construct(
        Data $helper,
        Stores $stores,
        WriterInterface $configWriter
    ) {
        $this->helper = $helper;
        $this->stores = $stores;
        $this->configWriter = $configWriter;
        $this->errors = [];
    }
    /**
     * Around Save
     *
     * @param \Magento\Config\Model\Config $subject
     * @param \Closure $proceed
     */
    public function aroundSave(
        \Magento\Config\Model\Config $subject,
        \Closure $proceed
    ) {
        if ($subject->getSection() == 'chatgpt') {
            $params = $subject->getGroups()['general_settings']['fields'];
            $storeId = $subject->getStore();
            $website = $subject->getWebsite();
            $fieldLabel = [
                'active' => __('Enable Module'),
                'secret' => __('Api Secret'),
                'gpt_model' => __('ChatGPT Model')
            ];
            $requiredParams = ['active', 'secret', 'gpt_model'];
            if (!$storeId && !$website) {
                if (isset($params['active']) && $params['active']['value']) {
                    foreach ($requiredParams as $key => $value) {
                        $this->isValid($params, $fieldLabel, $value);
                    }
                }
            }
            if (count($this->errors)) {
                foreach ($this->errors as $key => $value) {
                    throw new \Magento\Framework\Exception\LocalizedException($value);
                }
            }
        }
        return $proceed();
    }
    /**
     * Check required fields
     *
     * @param array $moduleFields
     * @param array $fieldLabel
     * @param string $value
     */
    private function isValid($moduleFields, $fieldLabel, $value)
    {
        if (!isset($moduleFields[$value]) || $moduleFields[$value]['value'] == '' ||
         $moduleFields[$value]['value'] == null) {
            array_push(
                $this->errors,
                __('Something went wrong while saving this configuration: %1', $fieldLabel[$value])
            );
            return false;
        }
        return true;
    }
}
