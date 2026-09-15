<?php

use TYPO3\CMS\Core\Core\Environment;

if (Environment::getContext()->isDevelopment()) {
  $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordPolicy'] = '';
  $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordPolicy'] = '';
}
