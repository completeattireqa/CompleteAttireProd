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
interface PostCommentRepositoryInterface
{
    /**
     * get comments by post id.
     *
     * @param int $postId
     *
     * @return object
     */
    public function getCommentsByPostId($postId);
}
