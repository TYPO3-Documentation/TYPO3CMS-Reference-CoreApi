<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
        // Your own persistent cache, registered in ext_localconf.php in the
        // 'pages' group so automatic cache clearing flushes it by tag on change.
        #[Autowire(service: 'cache.my_extension_detail')]
        protected readonly FrontendInterface $detailCache,
        // The runtime cache is registered by TYPO3 out of the box. It lives for
        // the duration of one request only and is never written to storage.
        #[Autowire(service: 'cache.runtime')]
        protected readonly FrontendInterface $runtimeCache,
    ) {}

    // A fixed marker the detail template renders where the strip belongs.
    private const RECOMMENDATIONS_PLACEHOLDER = '<!--###RECOMMENDATIONS###-->';

    // stable data, covered by flush-by-tag invalidation
    // we use one year here
    private const DETAIL_LIFETIME = 365 * 24 * 60 * 60;

    // The whole show action is non-cacheable, because the recommendations strip
    // sits in the middle of the detail view and cannot be split off into its own
    // content object. We rebuild the page cache's own trick by hand: cache the
    // stable HTML with a placeholder, then substitute the dynamic strip into it.
    public function showAction(Conference $conference): ResponseInterface
    {
        // Outer layer: the whole detail view, INCLUDING the placeholder marker.
        // It is identical for every visitor of this record and only changes when
        // the record does, so it belongs in a PERSISTENT cache. Tag it with the
        // record so a change flushes exactly this entry.
        $tag = 'tx_myextension_domain_model_conference_' . $conference->getUid();
        $html = $this->detailCache->get($tag);
        if ($html === false) {
            // Render the detail template once. It contains the literal marker
            // RECOMMENDATIONS_PLACEHOLDER at the spot the strip should appear.
            $html = $this->renderDetail($conference);
            $this->detailCache->set($tag, $html, [$tag], self::DETAIL_LIFETIME);
        }

        // Inner layer: the per-visitor recommendations strip. Because it must
        // differ per visitor and per revisit, it belongs in the RUNTIME cache.
        // The fixed key keeps it stable within THIS render.
        $strip = $this->runtimeCache->get('recommendations');
        if ($strip === false) {
            $conferences = $this->conferenceRepository->findRecommendations();
            $strip = $this->renderRecommendations($conferences);
            $this->runtimeCache->set('recommendations', $strip);
        }

        // Splice the freshly picked strip into the cached HTML — a plain string
        // replacement, exactly what TYPO3 does with its own USER_INT markers.
        // The result is returned directly and never cached, so the placeholder
        // stays in the cached copy and the next request can splice again.
        $html = str_replace(self::RECOMMENDATIONS_PLACEHOLDER, $strip, $html);

        return $this->htmlResponse($html);
    }

    private function renderDetail(Conference $conference): string
    {
        // Render the detail template to a string, for example with
        // $this->view->render('Conference/Show') after assigning $conference.
        // The template must contain RECOMMENDATIONS_PLACEHOLDER where the strip
        // should appear.
        return '…';
    }

    /**
     * @param iterable<Conference> $conferences The picked recommendations
     */
    private function renderRecommendations(iterable $conferences): string
    {
        // Render the recommendations partial to a string.
        return '…';
    }
}
