<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Hook;

use TYPO3\CMS\Core\DataHandling\DataHandler;

final class DataHandlerHook
{
  public function processDatamap_afterAllOperations(DataHandler $dataHandler): void
  {
    foreach ($dataHandler->datamap['tx_myextension_news'] ?? [] as $uid => $fields) {
      // ... a news record was saved ...
    }
  }
}
