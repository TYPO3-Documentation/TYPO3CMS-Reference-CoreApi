<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Event\Mvc\BeforeActionRateLimitResponseEvent;
use TYPO3\CMS\Frontend\Controller\ErrorController;

final readonly class RateLimitErrorPageListener
{
  #[AsEventListener('my_extension/rate-limit-error-page')]
  public function __invoke(BeforeActionRateLimitResponseEvent $event): void
  {
    $response = GeneralUtility::makeInstance(ErrorController::class)
        ->accessDeniedAction(
          $event->getRequest(),
          $event->getRateLimit()->message,
        );
    throw new PropagateResponseException($response, 1771077885);
  }
}
