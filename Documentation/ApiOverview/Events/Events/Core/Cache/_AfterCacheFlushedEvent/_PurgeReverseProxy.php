<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use MyVendor\MyExtension\Http\ReverseProxyClient;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Cache\Event\AfterCacheFlushedEvent;

final readonly class PurgeReverseProxy
{
  public function __construct(
    private ReverseProxyClient $reverseProxyClient,
  ) {}

  #[AsEventListener('my-extension/purge-reverse-proxy')]
  public function __invoke(AfterCacheFlushedEvent $event): void
  {
    if ($event->result->includesGroup('all') || $event->result->includesGroup('pages')) {
      $this->reverseProxyClient->purgeAll();
      return;
    }
    $tags = $event->result->getTags('pages');
    if ($tags !== []) {
      $this->reverseProxyClient->purgeTags($tags);
    }
  }
}
