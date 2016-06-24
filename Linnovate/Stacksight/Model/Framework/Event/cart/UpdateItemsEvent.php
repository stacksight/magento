<?php

namespace Linnovate\Stacksight\Model\Framework\Event\cart;

use Linnovate\Stacksight\Model\Stacksight;
use Magento\Backend\Model\UrlInterface;
use \Magento\Backend\Model\Auth\Session;
use Magento\Cms\Helper\Page;

class UpdateItemsEvent extends StacksightCartEvent
{
    const CART_ACTION = 'removed';
    const ACTION_SUB_TYPE = 'from cart';

    const TYPE_OF_ITEM = 'quote_item';

    public function __construct(Stacksight $stacksight, UrlInterface $url, Session $authSession, Page $cmsPage){
        parent::__construct($stacksight, $url, $authSession, $cmsPage);
    }

    public function getAction(){
        return self::CART_ACTION;
    }

    protected function getProductFromObserver(){
        $observer = $this->observer->getData(self::TYPE_OF_ITEM);
        return $observer->getProduct();
    }
}