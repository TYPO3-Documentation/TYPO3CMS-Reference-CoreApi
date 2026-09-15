<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Service\ConferenceService;

class SpecialConferenceController extends ConferenceController
{
  protected ConferenceService $conferenceService;

  public function injectConferenceService(
    ConferenceService $conferenceService,
  ): void {
    $this->conferenceService = $conferenceService;
  }
}
