<?php

namespace Linnovate\Stacksight\Model\Framework\Event\cart;

use Linnovate\Stacksight\Model\Stacksight;
use Magento\Backend\Model\UrlInterface;
use \Magento\Backend\Model\Auth\Session;
use Magento\Cms\Helper\Page;

class AddProductEvent extends StacksightCartEvent
{
    const CART_ACTION = 'added';
    const ACTION_SUB_TYPE = 'to cart';

    const TYPE_OF_ITEM = 'product';

    public function __construct(Stacksight $stacksight, UrlInterface $url, Session $authSession, Page $cmsPage){
        parent::__construct($stacksight, $url, $authSession, $cmsPage);
    }

    public function getAction(){
       return self::CART_ACTION;
    }
}