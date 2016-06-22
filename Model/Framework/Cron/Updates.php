<?php

namespace Linnovate\Stacksight\Model\Framework\Cron;

use Linnovate\Stacksight\Model\Stacksight as Stacksight;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\Module\ResourceInterface;
use Magento\Framework\Event\ObserverInterface;

class Updates implements ObserverInterface
{
    protected $logger;
    protected $stacksight;
    protected $module_list;
    protected $module_resource;

    public function __construct(\Psr\Log\LoggerInterface $logger, ModuleListInterface $module_list, ResourceInterface $module_resource, Stacksight $stacksight) {
        $this->logger = $logger;
        $this->module_list = $module_list;
        $this->stacksight = $stacksight;
        $this->module_resource = $module_resource;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
//        $this->logger->debug(
//            print_r($this->module_list->getAll(),true)
//        );
//        var_dump($this->module_resource->getDbVersion('Magento_BundleImportExport'));
//        print_r($this->module_list->getAll());
//        die('XXX');
        return $this;
    }
}