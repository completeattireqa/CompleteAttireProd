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

namespace Webkul\ChatGPT\Helper;

use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\InputException;

/**
 * Webkul ChatGPT Helper.
 */
class ChatGPT4 extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CHAT_GPT4_MODEL = "gpt-4";
    const CHAT_GPT4_END_POINT = "https://api.openai.com/v1/chat/completions";

   /**
    * @var ScopeConfigInterface
    */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @var DeploymentConfig
     */
    protected $deploymentConfig;

    /**
     * @var \Webkul\ChatGPT\Helper\Data $helper
     */
    protected $helper;

    /**
     * @var $gptModel
     */
    protected $gptModel;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     * @param \Webkul\ChatGPT\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Webkul\ChatGPT\Helper\Data $helper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_resource = $resource;
        $this->storeManager = $storeManager;
        $this->deploymentConfig = $deploymentConfig;
        $this->helper = $helper;
        $this->gptModel = self::CHAT_GPT4_MODEL;
    }

    /**
     * Get Response
     *
     * @param string $importType
     * @param mixed $client
     * @param string $prompt
     */
    public function getResponse($importType, $client, $prompt)
    {
        $params = [
            "model"=> $this->gptModel,
            "messages"=> [
                ["role"=> "user", "content"=> $prompt]
            ],
            "temperature"=> 1,
            "max_tokens"=> 2000,
            "frequency_penalty"=> 0,
            "presence_penalty"=> 0
        ];
        $client->post(self::CHAT_GPT4_END_POINT, $this->helper->getJsonEncode($params));
        $res = $this->helper->getJsonDecode($client->getBody(), true)['choices'][0]['message']['content'] ?? '';
        if (!$res || $res == '') {
            if ($importType == 'individual') {
                $res = $this->helper->getJsonDecode($client->getBody());
                if (isset($res['error'])) {
                    return [$client, $res];
                }
            } elseif ($importType == 'mass') {
                throw new InputException(
                    __("An error occurred while importing AI Content. 
            Please check your API keys and configurations, then try again.")
                );
            }
        }
        return [$client, $res];
    }
}
