<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final readonly class ConsoleCommandLogger
{
  public function __construct(
    private LoggerInterface $logger,
  ) {}

  #[AsEventListener(identifier: 'my-extension/console-error')]
  public function logError(ConsoleErrorEvent $event): void
  {
    $this->logger->error('Command {command} failed: {message}', [
      'command' => $event->getCommand()?->getName() ?? 'unknown',
      'message' => $event->getError()->getMessage(),
    ]);
  }

  #[AsEventListener(identifier: 'my-extension/console-terminate')]
  public function logExitCode(ConsoleTerminateEvent $event): void
  {
    if ($event->getExitCode() === 0) {
      return;
    }

    $this->logger->warning('Command {command} ended with exit code {exitCode}', [
      'command' => $event->getCommand()?->getName() ?? 'unknown',
      'exitCode' => $event->getExitCode(),
    ]);
  }
}
