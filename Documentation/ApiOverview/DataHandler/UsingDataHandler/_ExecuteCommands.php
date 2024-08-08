<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyClass
{
    public function executeCommands(): void
    {
        /** @var DataHandler $dataHandler */
        // Do not inject or reuse the DataHander as it holds state!
        // Do not use `new` as GeneralUtility::makeInstance handles dependencies
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        // Prepare the cmd array
        $cmd = [
            // ... the cmd structure ...
        ];

        // Registers the $cmd array inside the class and initialize the
        // class internally.
        $dataHandler->start([], $cmd);

        // Execute the commands.
        $dataHandler->process_cmdmap();
    }
}
