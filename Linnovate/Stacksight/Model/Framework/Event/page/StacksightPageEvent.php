<?php

namespace Linnovate\Stacksight\Model\Framework\Event\page;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
use Magento\Backend\Model\UrlInterface;
use Linnovate\Stacksight\Model\Framework\Event\interfaces\StacksightPageEventInterface;

abstract class StacksightPageEvent implements ObserverInterface, StacksightPageEventInterface
{
    const ACTION_TYPE = 'content';
    const ACTION_SUB_TYPE = 'page';

    private $stacksight;
    private $container;

    protected $url;
    protected $user;
    protected $authSession;
    protected $cmsPage;

    protected $observer;

    protected $post_data;

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
        $data = $this->observer->getData('object');
        $this->post_data = $data->getData();
        $this->user = $this->getUser();
        $event = $this->user;
        $this->sendEvent(array(
                'action' => $this->getAction(),
                'type' => self::ACTION_TYPE,
                'subtype' => self::ACTION_SUB_TYPE,
                'name' => $this->post_data['title'],
                'url' => $this->cmsPage->getPageUrl($this->post_data['page_id'])
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
        }
        return $event;
    }

    abstract public function getAction();
}