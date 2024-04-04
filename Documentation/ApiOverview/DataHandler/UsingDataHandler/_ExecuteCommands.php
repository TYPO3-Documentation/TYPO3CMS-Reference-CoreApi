<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    public function __construct(
        private readonly DataHandler $dataHandler,
    ) {}

    public function executeCommands(): void
    {
        // Prepare the cmd array
        $cmd = [
            // ... the cmd structure ...
        ];

        // Registers the $cmd array inside the class and initialize the
        // class internally.
        $this->dataHandler->start([], $cmd);

        // Execute the commands.
        $this->dataHandler->process_cmdmap();
    }
}
