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
namespace Webkul\Blog\Api;

/**
 * @api
 */
interface CategoryRepositoryInterface
{
    /**
     * get category collection by id.
     *
     * @param none
     *
     * @return object
     */
    public function getCategoryCollection();
}
