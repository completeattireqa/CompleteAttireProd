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
interface BlogCustomerRepositoryInterface
{
    /**
     * get customer data by id.
     *
     * @param int $customerId
     *
     * @return object
     */
    public function getCustomerDataById($customerId);

    /**
     * get customer data.
     *
     * @return object
     */
    public function getCustomerData();

     /**
      * get customer status by id.
      *
      * @return object
      */
    public function getCustomerStatusById($customerId);
}
