<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use TYPO3\CMS\Core\Attribute\AsNonSchedulableCommand;

#[AsCommand('myextension:import', 'Import data from external source')]
#[AsNonSchedulableCommand]
final class MyImportCommand extends Command
{
  // ...
}
