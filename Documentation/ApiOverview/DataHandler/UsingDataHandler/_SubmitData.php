<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    private DataHandler $dataHandler;

    public function __construct(DataHandler $dataHandler)
    {
        $this->dataHandler = $dataHandler;
    }

    public function submitData(): void
    {
        // Prepare the data array
        $data = [
            // ... the data ...
        ];

        // Register the $data array inside DataHandler and initialize the
        // class internally.
        $this->dataHandler->start($data, []);

        // Submit data and have all records created/updated.
        $this->dataHandler->process_datamap();
    }
}
