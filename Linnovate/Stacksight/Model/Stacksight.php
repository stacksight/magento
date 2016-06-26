<?php

namespace Linnovate\Stacksight\Model;

use Magento\CatalogRule\Model\Rule;
use Magento\Customer\Model\Session as CustomerModelSession;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\Helper\AbstractHelper as AbstractHelper;

class Stacksight implements StacksightInterface
{

    private $_ss_client;

    public function __construct(
        $token = false,
        $group = false,
        $app_id = false,
        $include_logs = false,
        $include_events = true
    ){
        if($token){
            if(!defined('STACKSIGHT_TOKEN') && $token){
                define('STACKSIGHT_TOKEN', $token);
            }
        } else{
            return;
            // We can notice that need set stacksight token
        }

        if($app_id){
            if(!defined('STACKSIGHT_APP_ID') && $app_id){
                define('STACKSIGHT_APP_ID', $app_id);
            }
        }

        if($group){
            if(!defined('STACKSIGHT_GROUP') && $group){
                define('STACKSIGHT_GROUP', $group);
            }
        }

        if($include_logs){
            if(!defined('STACKSIGHT_INCLUDE_LOGS') && $include_logs){
                define('STACKSIGHT_INCLUDE_LOGS', (bool) $include_logs);
            }
        }

        if($include_events){
            if(!defined('STACKSIGHT_INCLUDE_EVENTS') && $include_events){
                define('STACKSIGHT_INCLUDE_EVENTS', (bool) $include_events);
            }
        }

        global $ss_client;

        if(!$ss_client){
            require_once(__DIR__.'/../../../../stacksight-php-sdk/bootstrap-magento-2.php');
            $stacksight = new \Magento2Bootstrap();
            $this->_ss_client = $stacksight->getClient();
        } else{
            $this->_ss_client = $ss_client;
        }
    }

    public function getClient(){
        return $this->_ss_client;
    }
}