.. include:: /Includes.rst.txt

.. index:: Extbase; Repositories

===================================
Repository
===================================

All repositories inherit from :php:`\TYPO3\CMS\Extbase\Persistence\Repository`.

A repository is always responsible for precisely one type of domain object.

The naming of the repositories is important:
If the domain object is, for example, *Blog* (with full name
:php:`FriendsOfTYPO3\BlogExample\Domain\Model\Blog`),
then the corresponding repository is named *BlogRepository* (with the full name
`FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository`).

The :php:`\TYPO3\CMS\Extbase\Persistence\Repository` already offers a large
number of usefull functions. Therefore in simple classes extending the
class :php:`Repository` and leaving the class empty otherwise is sufficient.

The :php:`BlogRepository` sets some default orderings and is otherwise empty:

.. include:: /CodeSnippets/Extbase/Domain/BlogRepository.rst.txt

Magic find methods
===================

The class :php:`Repository` creates "magic" methods to find by attributes of
model.

:php:`findBy[Property]`
   Finds all objects with the provided property.

:php:`findOneBy[Property]`
   Returns the first object found with the provided property.

:php:`countBy[Property]`
   Counts all objects with the provided property.

If necessary these methods can also be overridden by implementing them in the
concrete repository.

Custom find methods
====================

Custom find methods can be implemented. They can be used, for example, to filter
by multiple properties, apply a different sorting. They can also be used for
complex queries.

.. attention::
   As Extbase repositories turn the results into objects querying large amounts
   of data is ressource intensive.

**Example:**

The :php:`PostRepository` of the blog example extension implements several
custom find methods, two of those shown below:

.. include:: /CodeSnippets/Extbase/Domain/CustomMethods.rst.txt

Query settings
===============

When the query settings should be used for all methods in the repository,
the should be set in the method :php:`initializeObject()` method.

.. include:: /CodeSnippets/Extbase/Domain/DefaultQuerySettings.rst.txt

.. attention::
   Depending on the query settings hidden or even deleted objects can become
   visible. This might be cause information disclosure. Use with care.

When the query settings should only be changed for a certain method they can be
set in the method itself:

.. include:: /CodeSnippets/Extbase/Domain/SpecialQuerySettings.rst.txt


Repository API
===============

.. include:: /CodeSnippets/Extbase/Api/Repository.rst.txt


Typo3QuerySettings and localization
===================================

Starting with version 9, Extbase renders the translated records in the same way TypoScript rendering does.

.. note::
   In previous version the behaviour was controllable by the feature switch :typoscript:`consistentTranslationOverlayHandling`
   which has been removed in newer versions.

1) Setting :php:`Typo3QuerySettings->languageMode` does **not** influence how Extbase queries records.
   The language mode is used by the core to decide what to do when a page is not translated to the given language (display 404 or try page with a different language).
   Users who used to set :php:`Typo3QuerySettings->languageMode` to `strict` should use
   :php:`Typo3QuerySettings->setLanguageOverlayMode('hideNonTranslated')` to get translated records only.

2) Setting :php:`Typo3QuerySettings->languageOverlayMode` to :php:`true` makes Extbase fetch records
   from default language and overlay them with translated values. So, e.g., when a record is hidden in
   the default language, it will not be shown. Also, records without translation parents will not be shown.
   For relations, Extbase reads relations from a translated record (so it’s not possible to inherit
   a field value from translation source) and then passes the related records through :php:`$pageRepository->getRecordOverlay()`.
   So, e.g., when you have a translated `tt_content` with FAL relation, Extbase will show only those
   `sys_file_reference` records which are connected to the translated record (not caring whether some of
   these files have `l10n_parent` set).

3) Setting :php:`Typo3QuerySettings->languageOverlayMode` to :php:`false` makes Extbase fetch aggregate
   root records from a given language only. Extbase will follow relations (child records) as they are,
   without checking their `sys_language_uid` fields, and then it will pass these records through
   :php:`$pageRepository->getRecordOverlay()`.
   This way, the aggregate root record's sorting and visibility don't depend on default language records.
   Moreover, the relations of a record, which are often stored using default language uids,
   are translated in the final result set (so overlay happens).

   For example:
   Given a translated `tt_content` record having a relation to 2 categories (in the mm table translated
   tt_content record is connected to category uid in default language), and one of the categories is translated.
   Extbase will return a `tt_content` model with both categories.
   If you want to have just translated category shown, remove the relation in the translated `tt_content`
   record in the TYPO3 backend.

Note that by default :php:`Typo3QuerySettings` uses the site language configuration.
So you need to change :php:`Typo3QuerySettings` manually only if your Extbase code should
behave different than other `tt_content` rendering.

Setting :php:`setLanguageOverlayMode()` on a query influences **only** fetching of the aggregate root. Relations are always
fetched with :php:`setLanguageOverlayMode(true)`.

When querying data in translated language, and having :php:`setLanguageOverlayMode(true)`, the relations
(child objects) are overlaid even if the aggregate root is not translated.
See :php:`QueryLocalizedDataTest->queryFirst5Posts()`.

The following examples show how to query data in Extbase in different scenarios, independent of the global TS settings:

1) Fetch records from the language uid=1 only, with no overlays.

.. code-block:: php
   :caption: EXT:sjr_offers/Classes/Domain/Repository/OfferRepository.php

   $querySettings = $query->getQuerySettings();
   $querySettings->setLanguageUid(1);
   $querySettings->setLanguageOverlayMode(false);

2) Fetch records from the language uid=1, with overlay, but hide non-translated records

.. code-block:: php
   :caption: EXT:sjr_offers/Classes/Domain/Repository/OfferRepository.php

   $querySettings = $query->getQuerySettings();
   $querySettings->setLanguageUid(1);
   $querySettings->setLanguageOverlayMode('hideNonTranslated');

:php:`$repository->findByUid()` and language overlays
=====================================================

:php:`$repository->findByUid()` internally sets :php:`respectSysLanguage(false)`.
Therefore it behaves differently
than a regular query by an :php:`uid` like :php:`$query->matching($query->equals('uid', 11));`
The regular query will return :php:`null` if passed :php:`uid` doesn't match
the language set in the :php:`$querySettings->setLanguageUid()` method.

The bottom line is you can use :php:`$repository->findByUid()` using translated
record uid to get the translated content independently from language set in the
global context.
