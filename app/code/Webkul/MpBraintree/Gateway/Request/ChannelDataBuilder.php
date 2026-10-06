<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Framework\App\ProductMetadataInterface;

/**
 * Class BnCodeDataBuilder
 */
class ChannelDataBuilder implements BuilderInterface
{
    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var string
     */
    private static $channel = 'channel';

    /**
     * @var string
     */
    private static $channelValue = 'Magento2_Cart_%s_BT';

    /**
     * Constructor
     *
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(ProductMetadataInterface $productMetadata)
    {
        $this->productMetadata = $productMetadata;
    }

    /**
     * @inheritdoc
     */
    public function build(array $buildSubject)
    {
        return [
            self::$channel => sprintf(self::$channelValue, $this->productMetadata->getEdition())
        ];
    }
}
