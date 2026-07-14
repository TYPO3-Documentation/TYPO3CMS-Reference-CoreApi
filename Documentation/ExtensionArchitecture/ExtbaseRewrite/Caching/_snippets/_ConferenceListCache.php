<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Dto\ConferenceDemand;
use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    // how long is acceptable for a new record to stay hidden?
    // we use 24 hours here
    private const LIST_LIFETIME = 24 * 60 * 60;

    // stable data, covered by flush-by-tag invalidation
    // we use one year here
    private const TEASER_LIFETIME = 365 * 24 * 60 * 60;

    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
        // Two of your own caches, registered in ext_localconf.php in the 'pages'
        // group so automatic cache clearing flushes them by tag on record change.
        #[Autowire(service: 'cache.my_extension_list')]
        protected readonly FrontendInterface $listCache,
        #[Autowire(service: 'cache.my_extension_teaser')]
        protected readonly FrontendInterface $teaserCache,
    ) {}

    public function listAction(ConferenceDemand $demand): ResponseInterface
    {
        // Outer layer: the whole rendered list. The identifier must contain
        // every option that shapes the result — the free-text search word, the
        // sorting, the pagination page AND every filter (categories, location,
        // …) fed from the conference's own properties. Hashing the whole normalised demand object
        // covers them in one step and cannot silently drop a filter you add later.
        $listIdentifier = 'list_' . hash('xxh3', serialize($demand->toArray()));

        $renderedList = $this->listCache->get($listIdentifier);
        if ($renderedList === false) {
            $conferences = $this->conferenceRepository->findByDemand($demand);

            // Inner layer: render each teaser once and cache it under its own
            // <table>_<uid> identifier, so an unchanged conference is reused
            // even when the surrounding list has to be rebuilt.
            $teasers = [];
            $tags = [];
            foreach ($conferences as $conference) {
                $tag = 'tx_myextension_domain_model_conference_' . $conference->getUid();
                $teaser = $this->teaserCache->get($tag);
                if ($teaser === false) {
                    $teaser = $this->renderTeaser($conference);
                    $this->teaserCache->set($tag, $teaser, [$tag], self::TEASER_LIFETIME);
                }
                $teasers[] = $teaser;
                $tags[] = $tag;
            }

            $renderedList = $this->renderList($teasers);
            // Tag the list with every teaser it contains. When one of those
            // conferences changes, automatic cache clearing flushes this list
            // entry by that tag; the rebuild reuses the teasers that did not change.
            $this->listCache->set($listIdentifier, $renderedList, $tags, self::LIST_LIFETIME);
        }

        return $this->htmlResponse($renderedList);
    }

    private function renderTeaser(Conference $conference): string
    {
        // Render one teaser partial to a string, for example with
        // $this->view->render('Conference/Teaser') after assigning $conference.
        return '…';
    }

    /**
     * @param list<string> $teasers Already-rendered teaser HTML fragments
     */
    private function renderList(array $teasers): string
    {
        // Render the surrounding list markup (form, sorting, pagination) and
        // place the teaser fragments into it.
        return '…';
    }
}
