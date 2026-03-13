<?php

namespace MyVendor\MyExtension\Log\Processor;

use TYPO3\CMS\Core\Log\LogRecord;

class MyProcessor extends \TYPO3\CMS\Core\Log\Processor\AbstractProcessor
{
    protected bool $option = true;

    public function setOption(bool $option): void
    {
        $this->option = $option;
    }

    public function processLogRecord(LogRecord $logRecord): LogRecord
    {
        // add magic

        return $logRecord;
    }
}
