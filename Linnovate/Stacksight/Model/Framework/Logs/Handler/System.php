<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Linnovate\Stacksight\Model\Framework\Logs\Handler;

use Linnovate\Stacksight\Model\Stacksight;
use Magento\Framework\Filesystem\DriverInterface;
use Monolog\Logger;

class System extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/stack_system.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * @var Exception
     */
    protected $exceptionHandler;

    /**
     * @{inheritDoc}
     *
     * @param $record array
     * @return void
     */
    public function write(array $record)
    {
        if(self::codeToString(strtolower($this->loggerType))){
            $this->stacksight->sendLog(self::generateDataStream($record), strtolower(self::codeToString($this->loggerType)));
        }
        parent::write($record);
    }
}
