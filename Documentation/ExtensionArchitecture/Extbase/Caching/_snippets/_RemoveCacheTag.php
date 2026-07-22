<?php

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function listAction(): ResponseInterface
    {
        $cacheCollector = $this->request->getAttribute('frontend.cache.collector');
        $cacheCollector->removeCacheTags(
            new CacheTag('tx_myextension_domain_model_location_5'),
        );

        return $this->htmlResponse();
    }
}
