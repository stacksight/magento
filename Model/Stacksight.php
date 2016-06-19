<?php

namespace Linnovate\Stacksight\Model;

use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogRule\Model\Rule;
use Magento\Customer\Model\Session as CustomerModelSession;
use Magento\Framework\Event\Observer as EventObserver;
use \Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfigInterface;

class Stacksight
{

    private $_ss_client;
    private $config;

    public function __construct(ScopeConfigInterface $scopeConfig){
        $token = $scopeConfig->getValue('general_section/general/stacksight_token');
        if($token){
            if(!defined('STACKSIGHT_TOKEN') && $token){
                define('STACKSIGHT_TOKEN', $token);
            }
        } else{
            return;
            // We can notice that need set stacksight token
        }

        $app_id = $scopeConfig->getValue('general_section/general/stacksight_app_id');
        if($app_id){
            if(!defined('STACKSIGHT_APP_ID') && $app_id){
                define('STACKSIGHT_APP_ID', $app_id);
            }
        }

        $group = $scopeConfig->getValue('general_section/general/stacksight_group_name');
        if($group){
            if(!defined('STACKSIGHT_GROUP') && $group){
                define('STACKSIGHT_GROUP', $group);
            }
        }

        $include_logs = $scopeConfig->getValue('features_section/features/stacksight_features_logs');
        if($include_logs){
            if(!defined('STACKSIGHT_INCLUDE_LOGS') && $include_logs){
                define('STACKSIGHT_INCLUDE_LOGS', (bool) $include_logs);
            }
        }

        $include_events = $scopeConfig->getValue('features_section/features/stacksight_features_events');
        if($include_events){
            if(!defined('STACKSIGHT_INCLUDE_EVENTS') && $include_events){
                define('STACKSIGHT_INCLUDE_EVENTS', (bool) $include_events);
            }
        }

        global $ss_client;

        if(!$ss_client){
            require_once(__DIR__.'/../src/sdk/bootstrap-magento-2.php');
            $stacksight = new \Magento2Bootstrap();
            $this->_ss_client = $stacksight->getClient();
        }
    }

    public function getClient(){
        return $this->_ss_client;
    }
}