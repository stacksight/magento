<?php

namespace Linnovate\Stacksight\Model\Framework\Event\auth;

class CustomerLogOutSuccessEvent extends CustomerLogInSuccessEvent
{
    const USER_ACTION = 'logged out';
}