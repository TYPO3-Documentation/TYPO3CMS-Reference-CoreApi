<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
    ) {}

    public function listAction(): ResponseInterface
    {
        $conferences = $this->conferenceRepository->findAll();

        // Auto-tagging tags the conferences the query returned, but not the
        // related location records. Follow the relation and tag each location
        // so the page is flushed when a location changes too:
        $cacheCollector = $this->request->getAttribute('frontend.cache.collector');
        foreach ($conferences as $conference) {
            $location = $conference->getLocation();
            if ($location !== null) {
                $cacheCollector->addCacheTags(
                    new CacheTag('tx_myextension_domain_model_location_' . $location->getUid()),
                );
            }
        }

        $this->view->assign('conferences', $conferences);
        return $this->htmlResponse();
    }
}
