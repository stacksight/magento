<?php

namespace Linnovate\Stacksight\Model\Framework\Event;

use Linnovate\Stacksight\Model\Framework\Event\interfaces\StacksightSendUserEventInterface;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
use Magento\Backend\Model\UrlInterface;

abstract class StacksightUserEvent implements ObserverInterface, StacksightSendUserEventInterface
{
    const ACTION_TYPE = 'user';

    private $stacksight;
    private $container;

    protected $url;
    protected $user;

    protected $observer;

    public function __construct($stacksight, $url){
        $this->stacksight = $stacksight->getClient();
        $this->url = $url;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->observer = $observer;
        $this->user = $this->getUser();
        $event = $this->getUserEventInfo();
        $this->sendEvent(array(
                'action' => $this->getAction(),
                'type' => self::ACTION_TYPE,
            ) + $event);

        return $this;
    }

    public function sendEvent($data){
        $this->stacksight->publishEvent($data);
    }

    abstract public function getUserEventInfo();

    abstract public function getUser();

    abstract public function getAction();
}