<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Linnovate\Stacksight\Model\Framework\Logs\Handler;

use Monolog\Logger;

class Exception extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/stack_exception.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::ERROR;

    public function write(array $record)
    {
        if(self::codeToString(strtolower($this->loggerType))){
//            $this->stacksight->sendLog(self::generateDataStream($record), strtolower($this->loggerType));
        }
//        print_r($record);
//        die();
        parent::write($record);
    }
}
