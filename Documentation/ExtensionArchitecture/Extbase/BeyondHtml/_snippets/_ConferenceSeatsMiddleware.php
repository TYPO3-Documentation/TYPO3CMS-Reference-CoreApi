<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Routing\SiteRouteResult;
use TYPO3\CMS\Core\Site\Entity\Site;

class ConferenceSeatsMiddleware implements MiddlewareInterface
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    $routing = $request->getAttribute('routing');
    $site = $request->getAttribute('site');
    if (!$routing instanceof SiteRouteResult
      || !$site instanceof Site
      || trim($routing->getTail(), '/') !== 'api/seats.json'
    ) {
      return $handler->handle($request);
    }

    if ($request->getMethod() !== 'GET') {
      return new JsonResponse(null, 405, ['Allow' => 'GET']);
    }

    $storagePid = (int)$site->getSettings()->get('myExtension.conferenceStoragePid', 0);
    if ($storagePid === 0) {
      return $handler->handle($request);
    }

    $seats = [];
    foreach ($this->conferenceRepository->findUpcomingInFolders([$storagePid]) as $conference) {
      $seats[] = [
        'uid' => $conference->getUid(),
        'seatsLeft' => $conference->getSeatsLeft(),
      ];
    }

    return new JsonResponse($seats, 200, ['Cache-Control' => 'no-store']);
  }
}
