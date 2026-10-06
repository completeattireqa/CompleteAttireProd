<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) 2010-2018 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\Blog\Model\Config\Source;

/**
 * BloggerApproval Class of Model Config Source
 */
class BloggerApproval
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $_manager;

    /**
     * Construct
     *
     * @param \Magento\Framework\Module\Manager                   $manager
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $config
     */
    public function __construct(
        \Magento\Framework\Module\Manager $manager,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $config
    ) {
    
        $this->_manager = $manager;
    }
    
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data =  [
                    ['value'=>'1', 'label'=>__('Auto')],
                    ['value'=>'0', 'label'=>__('Manual')]
        ];
        return $data;
    }
}
