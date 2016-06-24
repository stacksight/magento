<?php

namespace Linnovate\Stacksight\Model\Framework\Event\page;

use Linnovate\Stacksight\Model\Stacksight;
use Magento\Backend\Model\UrlInterface;
use \Magento\Backend\Model\Auth\Session;
use Magento\Cms\Helper\Page;

class PageDeleteEvent extends StacksightPageEvent
{
    const DELETE_ACTION = 'deleted';

    public function __construct(Stacksight $stacksight, UrlInterface $url, Session $authSession, Page $cmsPage){
        parent::__construct($stacksight, $url, $authSession, $cmsPage);
    }

    public function getAction(){
        return self::DELETE_ACTION;
    }
}