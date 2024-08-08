<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DataHandling;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyClass
{
    public function submitComplexData(): void
    {
        $data = [
            'pages' => [
                'NEW_1' => [
                    'pid' => 456,
                    'title' => 'Title for page 1',
                ],
                'NEW_2' => [
                    'pid' => 456,
                    'title' => 'Title for page 2',
                ],
            ],
        ];

        /** @var DataHandler $dataHandler */
        // Do not inject or reuse the DataHander as it holds state!
        // Do not use `new` as GeneralUtility::makeInstance handles dependencies
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        $dataHandler->reverseOrder = true;
        $dataHandler->start($data, []);
        $dataHandler->process_datamap();
        BackendUtility::setUpdateSignal('updatePageTree');
        $dataHandler->clear_cacheCmd('pages');
    }
}
