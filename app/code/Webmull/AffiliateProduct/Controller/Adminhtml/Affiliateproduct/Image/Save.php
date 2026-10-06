<?php
/**
 * Copyright 2016 © webmull. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * AffiliateProduct Module
 *
 * @author     webmull Team <info@websavari.com>
 */
namespace Webmull\AffiliateProduct\Controller\Adminhtml\Affiliateproduct\Image;

use Magento\Backend\App\Action\Context;
use Webmull\AffiliateProduct\Model\AffiliateProduct\ImageUploader\FileProcessor;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var FileProcessor
     * @since 100.1.0
     */
    protected $fileProcessor;

    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Webmull_AffiliateProduct::affiliateproduct';

    /**
     * @param Context $context
     * @param FileProcessor $fileProcessor
     */
    public function __construct(
        Context $context,
        FileProcessor $fileProcessor
    ) {
        parent::__construct($context);
        $this->fileProcessor = $fileProcessor;
    }
    /**
     * @inheritDoc
     * @since 100.1.0
     */
    public function execute()
    { 
    $result = $this->fileProcessor->saveToMedia(/*key($_FILES['product'])*/'product[affiliate_brand_image]');
        
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
