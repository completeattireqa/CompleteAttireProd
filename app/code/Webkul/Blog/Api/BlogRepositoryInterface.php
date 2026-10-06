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
interface BlogRepositoryInterface
{
    /**
     * get blog collection by user id.
     *
     * @param int $UserId
     *
     * @return object
     */
    public function getBlogCollectionByUserId($userId);

    /**
     * get blog collection by blog id.
     *
     * @param int $BlogId
     *
     * @return object
     */
    public function getBlogById($blogId);

    /**
     * get blog collection by category id.
     *
     * @param int $catgeoryId
     *
     * @return object
     */
    public function getBlogByCategoryId($categoryId);

    /**
     * get complete blog collection.
     *
     * @param none
     *
     * @return object
     */
    public function getBlogCollection();

    /**
     * get blog collection by tag Name.
     *
     * @param int $tagName
     *
     * @return object
     */
    public function getBlogByTagName($tagName);

    /**
     * get blog for title
     * @return object
     */
    public function getBlogForTitle();

    /**
     * does blog category exist
     * @return integer
     */
    public function doesCategoryExist($postId);

    /**
     * get BloggerId by Blog Id
     *
     * @return blogger id
     */
    public function getBloggerIdByBlogId($blogId);
}
