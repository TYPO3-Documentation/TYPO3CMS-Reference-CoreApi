..  include:: /Includes.rst.txt

..  index:: Extbase; Repositories
..  _extbase-repository:

==========
Repository
==========

All :ref:`Extbase <extbase>` repositories inherit from
:php:`\TYPO3\CMS\Extbase\Persistence\Repository`.

A repository is always responsible for precisely one type of
:ref:`domain object <extbase-model>`.

The naming of the repositories is important:
If the domain object is, for example, *Blog* (with full name
:php:`\FriendsOfTYPO3\BlogExample\Domain\Model\Blog`),
then the corresponding repository is named *BlogRepository* (with the full name
:php:`\FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository`).

The :php:`\TYPO3\CMS\Extbase\Persistence\Repository` already offers a large
number of useful functions. Therefore, in simple classes that extend the
:php:`Repository` class and leaving the class empty otherwise is sufficient.

The :php:`BlogRepository` sets some default orderings and is otherwise empty:

..  include:: /CodeSnippets/Extbase/Domain/BlogRepository.rst.txt

..  contents:: **Table of contents**
    :local:


Magic find methods
==================

The :php:`Repository` class creates "magic" methods to find by attributes of
model.

:php:`findBy[Property]`
   Finds all objects with the provided property.

:php:`findOneBy[Property]`
   Returns the first object found with the provided property.

:php:`countBy[Property]`
   Counts all objects with the provided property.

If necessary, these methods can also be overridden by implementing them in the
concrete repository.

Custom find methods
===================

Custom find methods can be implemented. They can be used, for example, to filter
by multiple properties or apply a different sorting. They can also be used for
complex queries.

..  attention::
    As Extbase repositories turn the results into objects, querying large
    amounts of data is resource-intensive.

**Example:**

The :php:`PostRepository` of the :t3ext:`blog` example extension implements
several custom find methods, two of them are shown below:

..  include:: /CodeSnippets/Extbase/Domain/CustomMethods.rst.txt

Query settings
===============

If the query settings should be used for all methods in the repository,
they should be set in the method :php:`initializeObject()` method.

..  include:: /CodeSnippets/Extbase/Domain/DefaultQuerySettings.rst.txt

..  attention::
    Depending on the query settings, hidden or even deleted objects can become
    visible. This might cause sensitive information to be disclosed. Use with care.

If you only want to change the query settings for a specific method, they can be
set in the method itself:

..  include:: /CodeSnippets/Extbase/Domain/SpecialQuerySettings.rst.txt


Repository API
===============

..  include:: /CodeSnippets/Extbase/Api/Repository.rst.txt

Typo3QuerySettings and localization
===================================

Extbase renders the translated records in the same way as TypoScript rendering.

..  versionchanged:: 11.0
    Setting :php:`Typo3QuerySettings->languageMode`  was deprecated and does
    **not** influence how Extbase queries records.

:php:`Typo3QuerySettings->languageOverlayMode` = true
-----------------------------------------------------

Setting :php:`Typo3QuerySettings->languageOverlayMode` to :php:`true`
will fetch records from the default language and overlay them
with translated values. If a record is hidden in the default language,
it will not be displayed in the translation. Also, records without translation
parents will not be shown.

For relations, Extbase reads relations from a translated record
(so it is not possible to inherit a field value from translation source)
and then passes the related records through
:php:`$pageRepository->getRecordOverlay()`.

For example: when you have a translated :sql:`tt_content` record with a
:ref:`FAL relation <fal>`, Extbase will show only those :sql:`sys_file_reference`
records which are connected to the translated record (not caring
whether some of these files have :sql:`l10n_parent` set).

:php:`Typo3QuerySettings->languageOverlayMode` = false
------------------------------------------------------

Setting :php:`Typo3QuerySettings->languageOverlayMode` to :php:`false`
will fetch aggregate root records from a given language only.

Extbase will follow relations (child records) as they are, without checking
their :sql:`sys_language_uid` fields, and then pass these
records through :php:`$pageRepository->getRecordOverlay()`.

This way, the aggregate root record's sorting and visibility do not depend on
the default language records.

Moreover, the relations of a record, which are often stored using default
language uids are translated in the final result set (so overlay happens).

Example: Given a translated :sql:`tt_content` record having a relation to two
categories (in the mm table the translated :sql:`tt_content` record is connected
to the category uid in the default language), and one of the categories is translated.
Extbase will return a :sql:`tt_content` model with both categories.

If you want just the translated category to be shown, remove the
relation in the translated :sql:`tt_content` record in the TYPO3 backend.


Setting the :php:`Typo3QuerySettings->languageOverlayMode`
----------------------------------------------------------

..  note::
    By default, :php:`Typo3QuerySettings` uses the
    :ref:`site language configuration <sitehandling-addingLanguages>`.

    You need to change :php:`Typo3QuerySettings` manually only, if your Extbase
    code should behave differently to :php:`tt_content` rendering.

Setting :php:`setLanguageOverlayMode()` on a query influences **only**
fetching of the aggregate root. Relations are always fetched with
:php:`setLanguageOverlayMode(true)`.

When querying data in translated language, and having
:php:`setLanguageOverlayMode(true)`, the relations (child objects) are overlaid
even if the aggregate root is not translated.

:php:`$repository->findByUid()` and language overlay modes
-----------------------------------------------------------

:php:`$repository->findByUid()` internally sets :php:`respectSysLanguage(false)`.

Therefore it behaves differently than a regular query by :php:`uid`.

..  note::
    :php:`$query->matching($query->equals('uid', 11));` and
    :php:`$repository->findByUid()` behave different in some language
    scenarios:

    The regular query will return :php:`null`, if passed :php:`uid` does not
    match the language set in the :php:`$querySettings->setLanguageUid()` method.

The bottom line is you can use :php:`$repository->findByUid()` with the translated
record uid to get the translated content, independently of the language set in the
global context.
