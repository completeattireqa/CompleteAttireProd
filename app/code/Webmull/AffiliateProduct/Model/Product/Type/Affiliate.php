<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Webmull\AffiliateProduct\Model\Product\Type;


class Affiliate extends \Magento\Catalog\Model\Product\Type\AbstractType
{
    const TYPE_ID = 'affiliate';

    public function save($product)
    {
        parent::save($product);
        // your additional saving logic
        return $this;
    }

    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product) {
    }

}
