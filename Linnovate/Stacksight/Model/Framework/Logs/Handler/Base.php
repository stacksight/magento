<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Linnovate\Stacksight\Model\Framework\Logs\Handler;

use Magento\Framework\Filesystem\DriverInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Linnovate\Stacksight\Model\Stacksight;

class Base extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var int
     */
    protected $loggerType = Logger::DEBUG;

    /**
     * @var DriverInterface
     */
    protected $filesystem;

    protected $stacksight;

    /**
     * @param DriverInterface $filesystem
     * @param string $filePath
     */
    public function __construct(
        DriverInterface $filesystem,
        Stacksight $stacksight,
        $filePath = null
    ) {
        $this->stacksight = $stacksight->getClient();
        parent::__construct($filesystem, $filePath);
    }

    /**
     * @{inheritDoc}
     *
     * @param $record array
     * @return void
     */
    public function write(array $record)
    {
        parent::write($record);
    }

    protected function generateDataStream($record)
    {
        return (string) $record['formatted'];
    }

    protected static function codeToString($code)
    {
        switch ($code){
            case Logger::EMERGENCY:
                return 'E_EMERGENCY';
            case Logger::ALERT:
                return 'E_PARSE';
            case Logger::CRITICAL:
                return 'E_ERROR';
            case Logger::ERROR:
                return 'E_ERROR';
            case Logger::WARNING:
                return 'E_WARNING';
            case Logger::NOTICE:
                return 'E_NOTICE';
            case Logger::INFO:
                return 'E_INFO';
            case Logger::DEBUG:
                return 'DEBUG';
        }
        return false;
    }
}