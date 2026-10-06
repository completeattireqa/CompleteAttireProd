<?php
/**
 * Webkul Software.
 *
 * @category Webkul
 *
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Logger;

class CronHandler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level.
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     *
     * @var int
     */
    protected $loggerType = CronLogger::DEBUG;

    /**
     * File name.
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     *
     * @var string
     */
    protected $fileName = '/var/log/braintreeCron.log';
}
