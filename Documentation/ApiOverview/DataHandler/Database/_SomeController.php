<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\ExampleModel;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Cache\CacheDataCollector;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class SomeController extends ActionController
{
    public function showAction(ExampleModel $example): ResponseInterface
    {
        // ...

        /** @var CacheDataCollector $cacheDataCollector */
        $cacheDataCollector = $this->request->getAttribute('frontend.cache.collector');
        $cacheDataCollector->addCacheTags(
            new CacheTag(sprintf('tx_myextension_example_%d', $example->getUid())),
        );

        // ...
    }
}
