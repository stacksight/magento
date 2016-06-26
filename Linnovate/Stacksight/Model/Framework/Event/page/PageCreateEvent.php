<?php

namespace Linnovate\Stacksight\Model\Framework\Event\page;

use Linnovate\Stacksight\Model\Stacksight;
use Magento\Backend\Model\UrlInterface;
use \Magento\Backend\Model\Auth\Session;
use Magento\Cms\Helper\Page;

class PageCreateEvent extends StacksightPageEvent
{
    const CREATE_ACTION = 'created';
    const UPDATE_ACTION = 'updated';

    public function __construct(Stacksight $stacksight, UrlInterface $url, Session $authSession, Page $cmsPage){
        parent::__construct($stacksight, $url, $authSession, $cmsPage);
    }

    public function getAction(){
        $data_object = $this->observer->getData('data_object');
        if($data_object->isObjectNew() === true){
            return self::CREATE_ACTION;
        } else{
            return self::UPDATE_ACTION;
        }
    }
}