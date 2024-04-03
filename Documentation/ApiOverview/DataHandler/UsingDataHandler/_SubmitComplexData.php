<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    public function __construct(
        private readonly DataHandler $dataHandler,
    ) {}

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

        $this->dataHandler->reverseOrder = true;
        $this->dataHandler->start($data, []);
        $this->dataHandler->process_datamap();
        BackendUtility::setUpdateSignal('updatePageTree');
        $this->dataHandler->clear_cacheCmd('pages');
    }
}
