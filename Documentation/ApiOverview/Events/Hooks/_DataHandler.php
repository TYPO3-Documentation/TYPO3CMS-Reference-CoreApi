<?php

namespace TYPO3\CMS\Core\DataHandling;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataHandler
{
  public function process_datamap()
  {
    $hookObjectsArr = [];
    foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'] ?? [] as $className) {
      // Instantiate hooks and call first hook method
      $hookObject = GeneralUtility::makeInstance($className);
      if (method_exists($hookObject, 'processDatamap_beforeStart')) {
        $hookObject->processDatamap_beforeStart($this);
      }
      $hookObjectsArr[] = $hookObject;
    }

    // ... process the data map ...

    foreach ($hookObjectsArr as $hookObj) {
      if (method_exists($hookObj, 'processDatamap_afterAllOperations')) {
        // When this hook gets called, all operations on the submitted data have been finished.
        $hookObj->processDatamap_afterAllOperations($this);
      }
    }
  }
}
