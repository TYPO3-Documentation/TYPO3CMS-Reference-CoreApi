..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend page information
..  _typo3-request-attribute-frontend-page-information:

=========================
Frontend page information
=========================

..  versionadded:: 13.0
    This request attribute replaces various page related properties of
    :ref:`\\TYPO3\\CMS\\Frontend\\Controller\\TyposcriptFrontendController <tsfe>`.

..  attention::
    The class is currently still marked as experimental. However, extension
    authors are encouraged to use information from this request attribute
    instead of the :php:`TyposcriptFrontendController` (TSFE) properties
    already: TYPO3 Core v13 will try to not break especially the getters /
    properties not marked as :php:`@internal`.

The :php:`frontend.page.information` frontend request attribute provides
frequently used page information. The attribute is attached to the PSR-7
frontend request by the :ref:`middleware <request-handling>`
:php:`TypoScriptFrontendInitialization`, middlewares below can rely on existence
of that attribute.

..  code-block:: php

    /** @var \TYPO3\CMS\Frontend\Page\PageInformation $pageInformation */
    $pageInformation = $request->getAttribute('frontend.page.information');

    // Formerly $tsfe->id
    $id = $pageInformation->getId();

    // Formerly $tsfe->page
    $page = $pageInformation->getPageRecord();

    // Formerly $tsfe->rootLine
    $rootLine = $pageInformation->getRootLine();

    // Formerly $tsfe->config['rootLine']
    $rootLine = $pageInformation->getLocalRootLine();


..  todo: Add API when class is not marked as internal anymore
