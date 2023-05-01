<?php

declare(strict_types=1);


defined('TYPO3') or die();

// Raise priority of service 'tx_example_sv1' to 110
$GLOBALS['TYPO3_CONF_VARS']['T3_SERVICES']['auth']['tx_example_sv1']['priority'] = 110;

// Disable service 'tx_example_sv1'
$GLOBALS['TYPO3_CONF_VARS']['T3_SERVICES']['auth']['tx_example_sv1']['enable'] = false;
