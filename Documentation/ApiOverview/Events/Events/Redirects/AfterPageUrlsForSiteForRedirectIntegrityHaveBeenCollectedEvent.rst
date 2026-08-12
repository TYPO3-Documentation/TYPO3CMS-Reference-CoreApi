..  include:: /Includes.rst.txt
..  index:: Events; AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent
..  _AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent:

================================================================
`AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent`
================================================================

..  versionadded:: 14.0

The PSR-14 event
:php:`\TYPO3\CMS\Redirects\Event\AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent`
allows TYPO3 Extensions to register event listeners to modify
the list of URLs that are being processed by the CLI command
`redirects:checkintegrity <https://docs.typo3.org/permalink/typo3/cms-redirects:redirects-checkintegrity>`_.

..  _after-page-urls-for-site-for-redirect-integrity-have-been-collected-event-example:

Example
=======

The event listener class, using the PHP attribute :php:`#[AsEventListener]` for
registration, adds the URLs found in a sites XML sitemap to the list of URLs.

..  literalinclude:: _AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

..  _after-page-urls-for-site-for-redirect-integrity-have-been-collected-event-api:

API
===

.. include:: /CodeSnippets/Events/Redirects/AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent.rst.txt
