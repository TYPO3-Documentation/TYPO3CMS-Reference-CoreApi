<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

class ImportCommand
{
  use \TYPO3\CMS\Core\Resource\ResourceInstructionTrait;

  protected function execute(): void
  {
    // ...

    // Skip the consistency check once for the specified storage,
    // source and target
    $this->skipResourceConsistencyCheckForCommands(
      $storage,
      $temporaryFileName,
      $targetFileName,
    );

    /** @var \TYPO3\CMS\Core\Resource\File $file */
    $file = $storage->addFile(
      $temporaryFileName,
      $targetFolder,
      $targetFileName,
    );
  }
}
