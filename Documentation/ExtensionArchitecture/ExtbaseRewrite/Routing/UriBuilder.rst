:navigation-title: UriBuilder

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; UriBuilder
..  _extbase-routing-uri-builder:

===================================
Generating URLs with the UriBuilder
===================================

The :php-short:`\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder` generates URLs
for Extbase actions. When routing configuration is in place, it produces the
clean URL defined by the matching route variant. Without routing configuration
it produces the raw namespaced query string.

The UriBuilder is available in two contexts: inside a controller action via
:php:`$this->uriBuilder`, and inside Fluid templates via :html:`<f:link.action>`
and :html:`<f:uri.action>`.


..  _extbase-routing-uri-builder-controller:

Generating URLs in a controller action
======================================

Use :php:`uriFor()` to generate a URL for any action. It is available as
:php:`$this->uriBuilder->uriFor()` in any controller action:

..  literalinclude:: _snippets/_ConferenceController-uriFor.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

:php:`uriFor()` signature:

..  code-block:: php

    uriFor(
        ?string $actionName = null,
        ?array $controllerArguments = null,
        ?string $controllerName = null,
        ?string $extensionName = null,
        ?string $pluginName = null,
    ): string

All parameters are optional. When omitted, the current controller, extension,
and plugin are used. Only pass :php:`$extensionName` and :php:`$pluginName`
when linking to a different plugin than the one handling the current request.


..  _extbase-routing-uri-builder-target-page:

Linking to a plugin on a different page
=======================================

The most common routing mistake: list and detail are on separate pages, but
the list template generates detail links without telling the UriBuilder which
page to target. The result is a link back to the list page instead of the
detail page.

Use :php:`setTargetPageUid()` before calling :php:`uriFor()`. :php:`reset()`
clears all previously set options — call it before each URL generation inside
a loop:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Model\Conference;
    use Psr\Http\Message\ResponseInterface;

    class ConferenceController extends ActionController
    {
        public function listAction(): ResponseInterface
        {
            $conferences = $this->conferenceRepository->findAll();

            foreach ($conferences as $conference) {
                $uri = $this->uriBuilder
                    ->reset()
                    ->setTargetPageUid(42)   // UID of the detail page
                    ->uriFor('show', ['conference' => $conference], 'Conference');

                // …
            }

            return $this->htmlResponse();
        }
    }

The detail page UID is typically stored in TypoScript settings (or site set
settings) so it does not need to be hardcoded:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    $detailPageUid = (int)($this->settings['detailPageUid'] ?? 0);

    $uri = $this->uriBuilder
        ->reset()
        ->setTargetPageUid($detailPageUid)
        ->uriFor('show', ['conference' => $conference], 'Conference');


..  _extbase-routing-uri-builder-absolute:

Absolute URLs
=============

For use in emails, JSON responses, or redirects, generate an absolute URL:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    $uri = $this->uriBuilder
        ->reset()
        ->setCreateAbsoluteUri(true)
        ->uriFor('show', ['conference' => $conference], 'Conference');


..  _extbase-routing-uri-builder-fluid:

Generating URLs in Fluid templates
==================================

:html:`<f:link.action>` and :html:`<f:uri.action>` are the Fluid equivalents of
:php:`uriFor()`. When routing configuration is in place, they produce the
same clean URLs automatically.

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

    <f:link.action action="show" controller="Conference" arguments="{conference: conference}">
        {conference.title}
    </f:link.action>

To link to a plugin on a different page, use :html:`pageUid`:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

    <f:link.action
        action="show"
        controller="Conference"
        arguments="{conference: conference}"
        pageUid="{settings.detailPageUid}"
    >
        {conference.title}
    </f:link.action>

For a plain URL string without an :html:`<a>` tag, use :html:`<f:uri.action>`
with the same attributes — useful when you need to construct the link yourself:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

    <a href="{f:uri.action(action: 'show', controller: 'Conference', arguments: '{conference: conference}', pageUid: settings.detailPageUid)}"
       title="{conference.title}"
       class="conference-link">{conference.title}</a>

..  seealso::

    *   `f:link.action ViewHelper reference <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-link-action>`_
    *   `f:uri.action ViewHelper reference <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-uri-action>`_


..  _extbase-routing-uri-builder-checklist:

Why is my URL not clean?
========================

If a URL comes out as a raw query string with ``cHash`` instead of the
expected clean URL, work through this list:

*   **No enhancer configured** — the plugin has no entry under
    :yaml:`routeEnhancers` in
    :file:`EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml`
    or :file:`config/sites/<site-identifier>/config.yaml`.
*   **Wrong page** — :php:`setTargetPageUid()` (or :html:`pageUid` in Fluid)
    is missing or points to the wrong page. The enhancer's :yaml:`limitToPages`
    must include the target page UID or match the page via an expression.
*   **No matching route variant** — the controller/action combination passed
    to :php:`uriFor()` does not match any :yaml:`_controller` entry in the
    :yaml:`routes` list in
    :file:`EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml`.
*   **Missing aspect** — a placeholder has a ``\d+`` requirement but no
    :ref:`StaticRangeMapper <extbase-routing-aspects-static-range>` or
    :ref:`StaticValueMapper <extbase-routing-aspects-static-value>` aspect,
    so TYPO3 cannot treat the parameter as static and appends ``cHash``.
*   **Stale cache** — after changing the site configuration, clear all caches
    via :guilabel:`Admin Tools > Maintenance`.

With URLs generating correctly, see :ref:`extbase-routing-examples` for
complete worked examples covering the most common plugin configurations.
