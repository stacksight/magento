<?php

namespace Linnovate\Stacksight\Model\Framework\Event\auth;

use Linnovate\Stacksight\Model\Stacksight;
use Magento\Backend\Model\UrlInterface;

class BackendAuthUserLogInSuccessEvent extends StacksightUserEvent
{
    const USER_ACTION = 'logged in';

    public function __construct(Stacksight $stacksight, UrlInterface $url){
        parent::__construct($stacksight, $url);
    }

    public function getUserEventInfo(){
        $event = array();
        $event['user'] = array('name' => $this->user->getEmail(), 'url' => $this->url->getUrl('adminhtml/system_account/index'));
        return $event;
    }

    public function getUser(){
        return $this->observer->getData('user');
    }

    public function getAction(){
        return self::USER_ACTION;
    }
}