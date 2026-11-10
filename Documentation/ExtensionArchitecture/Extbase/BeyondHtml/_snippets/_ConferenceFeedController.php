<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceFeedController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  protected function initializeFeedAction(): void
  {
    $this->request = $this->request->withFormat('xml');
  }

  public function feedAction(): ResponseInterface
  {
    $conferences = $this->conferenceRepository->findFiltered(
      (string)($this->settings['region'] ?? ''),
      (bool)($this->settings['currentYearOnly'] ?? false),
    );
    $this->view->assign('conferences', $conferences);

    return $this->responseFactory->createResponse()
      ->withHeader('Content-Type', 'application/rss+xml; charset=utf-8')
      ->withBody($this->streamFactory->createStream($this->view->render()));
  }
}
