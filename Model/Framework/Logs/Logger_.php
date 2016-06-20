<?php

namespace Linnovate\Stacksight\Model\Framework\Logs;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Psr\Log\LoggerInterface;
use Linnovate\Stacksight\Model\Stacksight;

class Logger extends \Monolog\Logger
{

}