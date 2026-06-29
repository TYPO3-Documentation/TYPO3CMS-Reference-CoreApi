..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend page information
..  _typo3-request-attribute-frontend-page-information:

=========================
Frontend page information
=========================

..  versionchanged:: 14.0
    This request attribute replaces various page related properties of removed
    :php-short:`\TYPO3\CMS\Frontend\Controller\TyposcriptFrontendController`.

The :php:`frontend.page.information` frontend request attribute provides
frequently used page information. The attribute is attached to the PSR-7
frontend request by the :ref:`middleware <request-handling>`
:php-short:`\TYPO3\CMS\Frontend\Middleware\PrepareTypoScriptFrontendRendering`, middlewares below can rely on existence
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


..  _typo3-request-attribute-frontend-page-information-api:

API
===

..  include:: /CodeSnippets/Manual/Entity/PageInformation.rst.txt
