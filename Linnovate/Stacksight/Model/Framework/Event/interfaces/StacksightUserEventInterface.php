<?php

namespace Linnovate\Stacksight\Model\Framework\Event\interfaces;

interface StacksightUserEventInterface
{
    public function getUserEventInfo();
    public function getUser();
    public function getAction();
}