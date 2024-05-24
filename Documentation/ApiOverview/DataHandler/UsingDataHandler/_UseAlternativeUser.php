<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyClass
{
    public function useAlternativeUser(BackendUserAuthentication $alternativeBackendUser): void
    {
        // Prepare the data array
        $data = [
            // ... the data ...
        ];

        // Prepare the cmd array
        $cmd = [
            // ... the cmd structure ...
        ];

        /** @var DataHandler $dataHandler */
        // Do not inject or reuse the DataHander as it holds state!
        // Do not use `new` as GeneralUtility::makeInstance handles dependencies
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        $dataHandler->start($data, $cmd, $alternativeBackendUser);
        $dataHandler->process_datamap();
        $dataHandler->process_cmdmap();
    }
}
