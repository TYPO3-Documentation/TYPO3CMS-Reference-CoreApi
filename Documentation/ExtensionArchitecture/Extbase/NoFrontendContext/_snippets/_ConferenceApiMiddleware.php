<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

class ConferenceApiMiddleware implements MiddlewareInterface
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    if (!str_ends_with($request->getUri()->getPath(), '/api/conferences.json')) {
      return $handler->handle($request);
    }

    $site = $request->getAttribute('site');
    $siteLanguage = $request->getAttribute('language');
    // Not set for URLs outside any site
    if (!$site instanceof Site || !$siteLanguage instanceof SiteLanguage) {
      return $handler->handle($request);
    }

    $storagePid = (int)$site->getSettings()->get('myExtension.conferenceStoragePid', 0);
    if ($storagePid === 0) {
      return $handler->handle($request);
    }

    $conferences = $this->conferenceRepository->findPublishedForApi(
      [$storagePid],
      LanguageAspectFactory::createFromSiteLanguage($siteLanguage),
    );

    $data = [];
    foreach ($conferences as $conference) {
      $data[] = [
        'title' => $conference->getTitle(),
        'date' => $conference->getEventDate()?->format('Y-m-d'),
      ];
    }
    return new JsonResponse($data);
  }
}
