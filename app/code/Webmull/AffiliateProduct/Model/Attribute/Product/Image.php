<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Webmull\AffiliateProduct\Model\Attribute\Product;

use Magento\Framework\App\Filesystem\DirectoryList;

class Image extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    protected $_uploaderFactory;
    protected $_filesystem;
    protected $_fileUploaderFactory;
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_logger = $logger;
    }

    public function afterSave($object)
    {
        $path = $this->_filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(
            'catalog/product/affiliate/'
        );
        $delete = $object->getData($this->getAttribute()->getName() . '_delete');

        $data = $object->getData($this->getAttribute()->getName());

        if (isset($data) && is_array($data)) {
            if (!empty($data['delete'])) {
                $result['file'] = null;
            } else {
                if (isset($data[0]['name']) && isset($data[0]['tmp_name'])) {
                    $result['file'] = $data[0]['name'];


                } else {
                    unset($result['file']);
                }
            }
        } else {
            $result['file'] = '';
        }
 
        if ($delete) {
            $fileName = $object->getData($this->getAttribute()->getName());
            $object->setData($this->getAttribute()->getName(), '');
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
            if ($this->_file->isExists($path.$fileName))  {
                $this->_file->deleteFile($path.$fileName);
            }
        }
 
        try {
            /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
            /*$uploader = $this->_fileUploaderFactory->create(['fileId' => 'product['.$this->getAttribute()->getName().']']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(true);
            $result = $uploader->save($path);*/

            $object->setData($this->getAttribute()->getName(), $result['file']);
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
        } catch (\Exception $e) {
            if ($e->getCode() != \Magento\MediaStorage\Model\File\Uploader::TMP_NAME_EMPTY) {
                $this->_logger->critical($e);
            }
        }
        
        return $this;
    }
}
