<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyClass
{
    public function __construct(
        private readonly ResourceFactory $resourceFactory,
    ) {}

    public function doSomething(): void
    {
        // Get file object with uid=42
        $fileObject = $this->resourceFactory->getFileObject(42);

        // Get content element with uid=21
        $contentElement = BackendUtility::getRecord('tt_content', 21);

        // Assemble DataHandler data
        $newId = 'NEW1234';
        $data = [];
        $data['sys_file_reference'][$newId] = [
            'uid_local' => $fileObject->getUid(),
            'tablenames' => 'tt_content',
            'uid_foreign' => $contentElement['uid'],
            'fieldname' => 'assets',
            'pid' => $contentElement['pid'],
        ];
        $data['tt_content'][$contentElement['uid']] = [
            'assets' => $newId, // For multiple new references $newId is a comma-separated list
        ];
        /** @var DataHandler $dataHandler */
        // Do not inject or reuse the DataHander as it holds state!
        // Do not use `new` as GeneralUtility::makeInstance handles dependencies
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        // Process the DataHandler data
        $dataHandler->start($data, []);
        $dataHandler->process_datamap();

        // Error or success reporting
        if ($dataHandler->errorLog === []) {
            // ... handle success
        } else {
            // ... handle errors
        }
    }
}
