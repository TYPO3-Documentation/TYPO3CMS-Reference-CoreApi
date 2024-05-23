<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyClass
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    public function handleError(): void
    {
        /** @var DataHandler $dataHandler */
        // Do not inject or reuse the DataHander as it holds state!
        // Do not use `new` as GeneralUtility::makeInstance handles dependencies
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        // ... previous call of DataHandler's process_datamap() or process_cmdmap()

        if ($dataHandler->errorLog !== []) {
            $this->logger->error('Error(s) while creating content element');
            foreach ($dataHandler->errorLog as $log) {
                // handle error, for example, in a log
                $this->logger->error($log);
            }
        }
    }
}
