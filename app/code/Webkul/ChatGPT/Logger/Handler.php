<?php
namespace Webkul\ChatGPT\Logger;

use Monolog\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Defines Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * Defines File name
     * @var string
     */
    protected $fileName = '/var/log/chatgpt.log';
}
