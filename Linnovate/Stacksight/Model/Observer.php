<?php

namespace Linnovate\Stacksight\Model;

use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogRule\Model\Rule;
use Magento\Customer\Model\Session as CustomerModelSession;
use Magento\Framework\Event\Observer as EventObserver;
use Linnovate\Stacksight\Model\Stacksight as Stacksight;

class Observer implements ObserverInterface
{

    private $_ss_client;
    private $container;

    public function __construct(Stacksight $stacksight){
        $this->_ss_client = $stacksight->getClient();
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        return $this;
    }
}