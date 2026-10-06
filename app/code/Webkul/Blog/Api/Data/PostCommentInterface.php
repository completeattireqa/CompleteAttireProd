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
namespace Webkul\Blog\Api\Data;

/**
 * Blog BlogCustomerInterface interface.
 *
 * @api
 */
interface PostCommentInterface
{
    /**
    * Constants for keys of data array. Identical to the name of the getter in snake case
    */
    const ENTITY_ID    = 'id';
    /***/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param  int $id
     * @return \Webkul\Blog\Api\Data\BlogCustomerInterface
     */
    public function setId($id);
}
