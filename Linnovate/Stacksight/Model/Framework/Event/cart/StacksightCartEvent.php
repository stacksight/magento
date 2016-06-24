<?php

namespace Linnovate\Stacksight\Model\Framework\Event\cart;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
use Magento\Backend\Model\UrlInterface;
use Linnovate\Stacksight\Model\Framework\Event\interfaces\StacksightPageEventInterface;

abstract class StacksightCartEvent implements ObserverInterface, StacksightPageEventInterface
{
    const ACTION_TYPE = 'order';

    private $stacksight;

    protected $url;
    protected $user;
    protected $authSession;
    protected $cmsPage;

    protected $observer;

    protected $item_data;

    public function __construct($stacksight, $url, $authSession, $cmsPage){
        $this->stacksight = $stacksight->getClient();
        $this->url = $url;
        $this->authSession = $authSession;
        $this->cmsPage = $cmsPage;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->observer = $observer;
        $product = $this->getProductFromObserver();
        $this->item_data = $product->getOrigData();
        $this->user = $this->getUser();
        $event = $this->user;
        $this->sendEvent(array(
                'action' => $this->getAction(),
                'type' => self::ACTION_TYPE,
                'subtype' => static::ACTION_SUB_TYPE,
                'name' => $this->item_data['name'],
                'url' => $product->getUrlInStore()
            ) + $event);

        return $this;
    }

    public function sendEvent($data){
        $this->stacksight->publishEvent($data);
    }

    protected function getUser(){
        $event = false;
        if($this->authSession->isLoggedIn()){
            $event = array();
            $user = $this->authSession->getUser();
            $event['user'] = array('name' => $user->getEmail(), 'url' => $this->url->getUrl('adminhtml/system_account/index'));
        } else{
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            $remote = $om->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
            $event['user'] = array('name' => $remote->getRemoteAddress(), 'url' => $storeManager->getStore()->getBaseUrl());
        }
        return $event;
    }

    protected function getProductFromObserver(){
        return $this->observer->getData(static::TYPE_OF_ITEM);
    }

    abstract public function getAction();
}