<?php

namespace Linnovate\Stacksight\Model\Framework\Event;

class CustomerLogOutSuccessEvent extends CustomerLogInSuccessEvent
{
    const USER_ACTION = 'logged out';
}