<?php

declare(strict_types=1);

use MyVendor\MyExtension\Routing\Aspect\MyCustomMapper;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['MyCustomMapperNameAsUsedInYamlConfig'] =
    MyCustomMapper::class;
