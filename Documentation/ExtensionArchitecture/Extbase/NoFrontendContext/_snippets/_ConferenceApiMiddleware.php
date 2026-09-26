<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;

class ConferenceApiMiddleware implements MiddlewareInterface
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
    protected readonly Context $context,
  ) {}

  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    $site = $request->getAttribute('site');
    $siteLanguage = $request->getAttribute('language');

    // Running before the frontend middlewares, neither attribute is set.
    if (!$site instanceof SiteInterface) {
      return $handler->handle($request);
    }

    if ($siteLanguage === null) {
      // No language resolved yet: choose one and build the aspect that
      // the frontend would have built for it.
      $siteLanguage = $site->getDefaultLanguage();
      $this->context->setAspect(
        'language',
        LanguageAspectFactory::createFromSiteLanguage($siteLanguage),
      );
    }

    $conferences = $this->conferenceRepository->findAll();

    // Build a response from $conferences

    return $handler->handle($request);
  }
}
