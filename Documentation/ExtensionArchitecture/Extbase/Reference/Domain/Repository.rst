.. include:: /Includes.rst.txt

.. index:: Extbase; Repositories
.. _extbase-repository:

==========
Repository
==========

All repositories inherit from :php:`\TYPO3\CMS\Extbase\Persistence\Repository`.

A repository is always responsible for precisely one type of domain object.

The naming of the repositories is important:
If the domain object is, for example, *Blog* (with full name
:php:`FriendsOfTYPO3\BlogExample\Domain\Model\Blog`),
then the corresponding repository is named *BlogRepository* (with the full name
`FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository`).

The :php:`\TYPO3\CMS\Extbase\Persistence\Repository` already offers a large
number of useful functions. Therefore in simple classes extending the
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
   visible. This might cause sensitive information to be disclosed. Use with care.

When the query settings should only be changed for a certain method they can be
set in the method itself:

.. include:: /CodeSnippets/Extbase/Domain/SpecialQuerySettings.rst.txt


Repository API
===============

.. include:: /CodeSnippets/Extbase/Api/Repository.rst.txt

Typo3QuerySettings and localization
===================================

Extbase renders the translated records in the same way TypoScript rendering
does.

..  versionchanged:: 11.0
    Setting :php:`Typo3QuerySettings->languageMode`  was deprecated and does
    **not** influence how Extbase queries records.

:php:`Typo3QuerySettings->languageOverlayMode` = true
-----------------------------------------------------

Setting :php:`Typo3QuerySettings->languageOverlayMode` to :php:`true`
makes Extbase fetch records from default language and overlay them
with translated values. When a record is hidden in the default language,
it is not displayed in the translation. Also, records without translation
parents will not be shown.

For relations, Extbase reads relations from a translated record
(so it’s not possible to inherit a field value from translation source)
and then passes the related records through
:php:`$pageRepository->getRecordOverlay()`.

For example: when you have a translated :sql:`tt_content` record with a
FAL relation, Extbase will show only those :sql:`sys_file_reference`
records which are connected to the translated record (not caring
whether some of these files have :sql:`l10n_parent` set).

:php:`Typo3QuerySettings->languageOverlayMode` = false
------------------------------------------------------

Setting :php:`Typo3QuerySettings->languageOverlayMode` to :php:`false`
makes Extbase fetch aggregate root records from a given language only.

Extbase will follow relations (child records) as they are, without checking
their :sql:`sys_language_uid` fields, and then it will pass these
records through :php:`$pageRepository->getRecordOverlay()`.

This way, the aggregate root record's sorting and visibility do not depend on
the default language records.

Moreover, the relations of a record, which are often stored using default
language uids are translated in the final result set (so overlay happens).

Example: Given a translated :sql:`tt_content` record having a relation to two
categories (in the mm table translated tt_content record is connected to
category uid in default language), and one of the categories is translated.
Extbase will return a :sql:`tt_content` model with both categories.

If you want to have just translated category shown, remove the
relation in the translated :sql:`tt_content` record in the TYPO3 backend.


Setting the :php:`Typo3QuerySettings->languageOverlayMode`
----------------------------------------------------------

..  note::
    By default :php:`Typo3QuerySettings` uses the site language configuration.

    You need to change :php:`Typo3QuerySettings` manually only if your Extbase
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
    :php:`$repository->findByUid()` do behave different in some language
    scenarios:

    The regular query will return :php:`null` if passed :php:`uid` doesn't match
    the language set in the :php:`$querySettings->setLanguageUid()` method.

The bottom line is you can use :php:`$repository->findByUid()` using translated
record uid to get the translated content independently from language set in the
global context.
