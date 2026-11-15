<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Finishers\FinisherInterface;
use TYPO3\CMS\Form\Event\BeforeFinishersAreExecutedEvent;

final readonly class SkipConfirmationEmailListener
{
  #[AsEventListener(
    identifier: 'my-extension/skip-confirmation-email',
  )]
  public function __invoke(BeforeFinishersAreExecutedEvent $event): void
  {
    if ($event->formRuntime->getIdentifier() !== 'newsletterSignup') {
      return;
    }
    $formValues = $event->finisherContext->getFormValues();
    if (($formValues['sendConfirmationEmail'] ?? 'yes') !== 'no') {
      return;
    }
    // Remove the email to the sender, keep all other finishers
    $event->finishers = array_values(array_filter(
      $event->finishers,
      static fn(FinisherInterface $finisher): bool =>
        !$finisher instanceof AbstractFinisher
        || $finisher->getFinisherIdentifier() !== 'EmailToSender',
    ));
  }
}
