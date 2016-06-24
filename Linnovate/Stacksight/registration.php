<?php

use Magento\Framework\Component\ComponentRegistrar as Registrar;
use Linnovate\Stacksight\Config as Config;

Registrar::register(Registrar::MODULE, Config::MODULE, __DIR__);