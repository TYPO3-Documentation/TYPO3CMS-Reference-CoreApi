<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    private DataHandler $dataHandler;
    private LoggerInterface $logger;

    public function __construct(DataHandler $dataHandler, LoggerInterface $logger)
    {
        $this->dataHandler = $dataHandler;
        $this->logger = $logger;
    }

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
