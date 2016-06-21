<?php

namespace Linnovate\Stacksight\Model\Framework\Event\interfaces;

interface StacksightSendUserEventInterface
{
    public function getUserEventInfo();
    public function getUser();
    public function getAction();
}