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
namespace Webkul\Blog\Ui\Component\MassAction\Comment;

use Magento\Framework\UrlInterface;
use Zend\Stdlib\JsonSerializable;
use Webkul\Blog\Model\ResourceModel\PostComment\CollectionFactory;

/**
 * Class Action
 */
class Action implements JsonSerializable
{
    /**
     * @var array
     */
    protected $_options;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * Additional options params
     *
     * @var array
     */
    protected $_data;

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * Base URL for subactions
     *
     * @var string
     */
    protected $_urlPath;

    /**
     * Param name for subactions
     *
     * @var string
     */
    protected $_paramName;

    /**
     * Additional params for subactions
     *
     * @var array
     */
    protected $_additionalData = [];
    
    /**
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_getRequest;
    
    /**
     *
     * @param CollectionFactory                       $collectionFactory
     * @param \Magento\Framework\App\RequestInterface $getRequest
     * @param UrlInterface                            $urlBuilder
     * @param array                                   $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        \Magento\Framework\App\RequestInterface $getRequest,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->_getRequest = $getRequest;
        $this->_collectionFactory = $collectionFactory;
        $this->_data = $data;
        $this->_urlBuilder = $urlBuilder;
    }

    /**
     * Get action options
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $postId =  $this->_getRequest->getParam('post_id');
        if ($this->_options === null) {
            $i=0;
            $options[0]['value']=1;
            $options[0]['label']=__("Approve");
            $options[1]['value']=0;
            $options[1]['label']=__("Reject");
            $options[2]['value']=2;
            $options[2]['label']=__("Delete");
            $this->prepareData();
            foreach ($options as $optionCode) {
                $this->_options[$optionCode['value']] = [
                    'type' => 'postid_' . $optionCode['value'],
                    'label' => $optionCode['label'],
                ];

                if ($this->_urlPath && $this->_paramName) {
                    $this->_options[$optionCode['value']]['url'] = $this->_urlBuilder->getUrl(
                        $this->_urlPath,
                        [$this->_paramName => $optionCode['value'],'post_id'=>$postId]
                    );
                }

                $this->_options[$optionCode['value']] = array_merge_recursive(
                    $this->_options[$optionCode['value']],
                    $this->_additionalData
                );
            }
            $this->_options = array_values($this->_options);
        }
        return $this->_options;
    }

    /**
     * Prepare addition data for subactions
     *
     * @return void
     */
    protected function prepareData()
    {
        foreach ($this->_data as $key => $value) {
            switch ($key) {
                case 'urlPath':
                    $this->_urlPath = $value;
                    break;
                case 'paramName':
                    $this->_paramName = $value;
                    break;
                default:
                    $this->_additionalData[$key] = $value;
                    break;
            }
        }
    }
}
