<?php
namespace Webmull\AffiliateProduct\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Webmull\AffiliateProduct\Model\AffiliateProduct\ImageUploader\FileProcessor;

class File extends AbstractModifier
{
    /**
     * @var Magento\Framework\Stdlib\ArrayManager
     */
    protected $arrayManager;
    /**
     * @var FileProcessor
     * @since 100.1.0
     */
    protected $fileProcessor;

    /**
     * @param ArrayManager                $arrayManager
     * @param FileProcessor                $fileProcessor
     */
    public function __construct(
        ArrayManager $arrayManager,
        FileProcessor $fileProcessor
    ) {
        $this->arrayManager = $arrayManager;
        $this->fileProcessor = $fileProcessor;
    }

    public function modifyMeta(array $meta)
    {
        $fieldCode = 'affiliate_brand_image';
        $elementPath = $this->arrayManager->findPath($fieldCode, $meta, null, 'children');
        $containerPath = $this->arrayManager->findPath(static::CONTAINER_PREFIX . $fieldCode, $meta, null, 'children');

        if (!$elementPath) {
            return $meta;
        }

        $meta = $this->arrayManager->merge(
            $containerPath,
            $meta,
            [
                'children'  => [
                    $fieldCode => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'elementTmpl'   => 'ui/form/element/uploader/uploader',
                                    'previewTmpl' => 'Webmull_AffiliateProduct/image-preview',
                                    'notice'=> 'Allowed file types: png, gif, jpg, jpeg.',
                                    'formElement' => 'fileUploader',
                                    'uploaderConfig' => ['url' => 'affiliateproduct/affiliateproduct_image/save']
                                ],
                            ],
                        ],
                    ]
                ]
            ]
        );
        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    { 
        $fieldCode = 'affiliate_brand_image';
        $itemData = $data;
        foreach ($itemData as $key => $_item) {
            if (array_key_exists('product', $_item)){
                if (array_key_exists($fieldCode, $_item['product']) && $_item['product'][$fieldCode]){
                        $_item['product'][$fieldCode] = [
                        0 => [
                            'file' => $_item['product'][$fieldCode],
                            'url' => $this->fileProcessor->getMediaUrl($_item['product'][$fieldCode])
                        ]
                    ];    
                }
                $data[$key] = $_item;
            }
        }
        return $data;
    }
}