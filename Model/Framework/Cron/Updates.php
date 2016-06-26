<?php

namespace Linnovate\Stacksight\Model\Framework\Cron;

use Linnovate\Stacksight\Console\Command\UpdatesCommand;

class Updates
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        return $this;
    }
}