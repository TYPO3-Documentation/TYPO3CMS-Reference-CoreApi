<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    public function __construct(
        private readonly DataHandler $dataHandler,
        private readonly LoggerInterface $logger,
    ) {}

    public function handleError(): void
    {
        // ... previous call of DataHandler's process_datamap() or process_cmdmap()

        if ($this->dataHandler->errorLog !== []) {
            $this->logger->error('Error(s) while creating content element');
            foreach ($this->dataHandler->errorLog as $log) {
                // handle error, for example, in a log
                $this->logger->error($log);
            }
        }
    }
}
