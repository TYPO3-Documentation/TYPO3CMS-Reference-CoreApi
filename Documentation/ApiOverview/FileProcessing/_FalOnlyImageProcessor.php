<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\Processing;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Processing\LocalImageProcessor;
use TYPO3\CMS\Core\Resource\Processing\TaskInterface;

class FalOnlyImageProcessor extends LocalImageProcessor
{
  public function canProcessTask(TaskInterface $task): bool
  {
    // Leave system resources from EXT: and PKG: to the Core processors
    return $task->getSourceFile() instanceof File
        && parent::canProcessTask($task);
  }
}
