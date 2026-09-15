<?php

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function listAction(): ResponseInterface
  {
    $conferences = $this->conferenceRepository->findAll();

    foreach ($conferences as $conference) {
      $uri = $this->uriBuilder
        ->reset()
        // UID of the detail page
        ->setTargetPageUid(42)
        ->uriFor('show', ['conference' => $conference], 'Conference');

      // …
    }

    return $this->htmlResponse();
  }
}
