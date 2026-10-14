<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\AfterFormStateInitializedEvent;

final readonly class CampaignFromQueryListener
{
  #[AsEventListener(
    identifier: 'my-extension/campaign-from-query',
  )]
  public function __invoke(AfterFormStateInitializedEvent $event): void
  {
    $formState = $event->formRuntime->getFormState();
    if ($formState === null) {
      return;
    }
    // Remember the campaign the visitor came from, unless already set
    $campaign = $event->request->getQueryParams()['campaign'] ?? '';
    if ($campaign !== '' && $formState->getFormValue('campaign') === null) {
      $formState->setFormValue('campaign', $campaign);
    }
  }
}
