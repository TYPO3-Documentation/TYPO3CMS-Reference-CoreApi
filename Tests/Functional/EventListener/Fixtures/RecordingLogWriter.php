<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\EventListener\Fixtures;

use TYPO3\CMS\Core\Log\LogRecord;
use TYPO3\CMS\Core\Log\Writer\AbstractWriter;

/**
 * Keeps the log records in memory, so that a test can read them.
 */
final class RecordingLogWriter extends AbstractWriter
{
  /** @var list<LogRecord> */
  public static array $records = [];

  public function writeLog(LogRecord $record): self
  {
    self::$records[] = $record;
    return $this;
  }
}
