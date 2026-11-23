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
    :caption: EXT:my_extension/Classes/Middleware/MyMiddleware.php (excerpt)

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

..  _typo3-request-attribute-frontend-page-information-record:

The current page as record object
=================================

..  versionadded:: 15.0
    :changelog: feature-108866-1793383685

    The method :php:`getRecord()` was added.

:php:`getRecord()` returns the current page as a
:ref:`record object <database-record-objects>`, which implements
:php:`\TYPO3\CMS\Core\Domain\RecordInterface`. It is created from the same
page row that :php:`getPageRecord()` returns, after shortcuts and mount points
are resolved and with the language overlay of a translated page.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Middleware/MyMiddleware.php (excerpt)

    $page = $request->getAttribute('frontend.page.information')->getRecord();

    $title = $page->get('title');

    // File references, resolved on first access
    $media = $page->get('media');

    // The uid of the page in the default language
    $uid = $page->getUid();

    // The uid of the translation, null in the default language
    $localizedUid = $page->getComputedProperties()->getLocalizedUid();

    // System fields are system properties of the record object
    $createdAt = $page->getSystemProperties()?->getCreatedAt();

The fields of the record are transformed according to their TCA
configuration. For example, relations such as :sql:`media` are file
references. The record holds only the fields of the page type. System fields,
such as :sql:`crdate` or :sql:`starttime`, are no fields of the record. Use
:php:`getSystemProperties()`, or :php:`getPageRecord()`, which still holds
them under their column names.

The record is available once the page and the language are resolved, after
the event
:ref:`AfterPageAndLanguageIsResolvedEvent <AfterPageAndLanguageIsResolvedEvent>`.


..  _typo3-request-attribute-frontend-page-information-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Frontend\Page\PageInformation
