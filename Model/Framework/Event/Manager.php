<?php
/**
 * Copyright © 2015 Cedcommerce. All rights reserved.
 */
namespace Linnovate\Stacksight\Model\Framework\Event;

class Manager extends \Magento\Framework\Event\Manager
{


    /**
     * Events cache
     *
     * @var array
     */
    protected $_events = [];
    /**
     * Event invoker
     *
     * @var InvokerInterface
     */
    protected $_invoker;
    /**
     * Event config
     *
     * @var ConfigInterface
     */
    protected $_eventConfig;

    /**
     * DeveloperTool Helper
     *
     * @var \Ced\DevTool\Helper\Data
     */
    protected $_devHelper;

    /**
     * @param InvokerInterface $invoker
     * @param ConfigInterface $eventConfig
     */
    public function __construct(\Magento\Framework\Event\InvokerInterface $invoker, \Magento\Framework\Event\ConfigInterface $eventConfig,
                                \Linnovate\Stacksight\Helper\Data $helper)
    {
        $this->_invoker = $invoker;
        $this->_eventConfig = $eventConfig;
        $this->_devHelper =$helper;
    }
    public function dispatch($eventName, array $data = [])
    {
        die('XXX');
    }
}