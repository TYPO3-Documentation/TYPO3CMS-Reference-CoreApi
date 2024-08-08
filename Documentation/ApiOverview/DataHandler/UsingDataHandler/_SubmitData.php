<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyClass
{
    public function submitData(): void
    {
        // Prepare the data array
        $data = [
            // ... the data ...
        ];

        /** @var DataHandler $dataHandler */
        // Do not inject or reuse the DataHander as it holds state!
        // Do not use `new` as GeneralUtility::makeInstance handles dependencies
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        // Register the $data array inside DataHandler and initialize the
        // class internally.
        $dataHandler->start($data, []);

        // Submit data and have all records created/updated.
        $dataHandler->process_datamap();
    }
}
