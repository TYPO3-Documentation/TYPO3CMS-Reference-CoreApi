<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
  'MyExtension',
  'ConferenceList',
  'my_extension.db:plugin.conferencelist.title',
  'my-extension-conference-list',
  'plugins',
  'my_extension.db:plugin.conferencelist.description',
  'EXT:my_extension/Configuration/FlexForms/ConferenceList.xml',
);
