<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\XmlSitemap;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Seo\XmlSitemap\XmlSitemap;
use TYPO3\CMS\Seo\XmlSitemap\XmlSitemapDataProviderInterface;
use TYPO3\CMS\Seo\XmlSitemap\XmlSitemapRequest;

final readonly class EventProvider implements XmlSitemapDataProviderInterface
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function getSitemap(XmlSitemapRequest $sitemapRequest): XmlSitemap
  {
    $configuration = $sitemapRequest->configuration;
    $queryBuilder = $this->connectionPool
      ->getQueryBuilderForTable('tx_myextension_event');
    $result = $queryBuilder
      ->select('uid', 'tstamp')
      ->from('tx_myextension_event')
      ->where($queryBuilder->expr()->eq(
        'pid',
        $queryBuilder->createNamedParameter(
          (int)($configuration['pid'] ?? 0),
          Connection::PARAM_INT,
        ),
      ))
      ->orderBy('uid')
      ->executeQuery();

    $items = [];
    while ($row = $result->fetchAssociative()) {
      $items[] = ['uid' => $row['uid'], 'lastMod' => $row['tstamp']];
    }

    // The URLs are generated for the items of the requested page only
    $contentObjectRenderer = $sitemapRequest->contentObjectRenderer;
    $detailPid = (int)($configuration['detailPid'] ?? 0);
    return XmlSitemap::forPage(
      $items,
      $sitemapRequest->page,
      static fn(array $item): array => $item + [
        'loc' => $contentObjectRenderer->createUrl([
          'parameter' => $detailPid,
          'additionalParams' => '&tx_myextension_event[event]=' . $item['uid'],
          'forceAbsoluteUrl' => true,
        ]),
      ],
    );
  }
}
