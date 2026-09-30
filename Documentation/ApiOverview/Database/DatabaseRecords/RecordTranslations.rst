:navigation-title: Record translations

..  include:: /Includes.rst.txt
..  index:: Database records; Translations
..  _record-translations:

===========================================
Fetch the translations of a database record
===========================================

..  versionadded:: 14.2
    :changelog: feature-108799-1738094060

:php:`\TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository`
reads the translations that exist for a record. Inject it into the class that
needs them:

..  literalinclude:: _CodeSnippets/_RecordTranslationService.php
    :caption: EXT:my_extension/Classes/Service/RecordTranslationService.php
    :visible-lines: 12-41

The repository returns the translations only, never the record in the
default language. The values come as
:php-short:`\TYPO3\CMS\Core\Domain\RawRecord` objects, which carry the
values as they are stored, without the resolved relations of a
:ref:`record object <record-objects>`.

A table that TCA does not describe, or that is not language aware, yields
`null` or an empty array rather than an error.

The repository applies the workspace overlay and leaves out the placeholder
records of a deleted translation. It does not read the backend user, so it
answers the same in a console command as in a backend module.

..  _record-translations-methods:

Methods of the localization repository
======================================

`getRecordTranslation($tableOrSchema, $recordOrUid, $language)`
    The translation of a record in one language, or `null` when there is
    none.

`getRecordTranslations($tableOrSchema, $recordOrUid, $limitToLanguageIds)`
    Every translation of a record, indexed by language ID. `count()` on the
    result is the number of translations.

`getPageTranslations($pageUid, $limitToLanguageIds)`
    Every translation of a page, indexed by language ID.

Name the table either as a string or as a
:php-short:`\TYPO3\CMS\Core\Schema\TcaSchema`, and the record either as its
uid, as the record array or as a
:php-short:`\TYPO3\CMS\Core\Domain\RecordInterface`. Passing the whole record
lets the repository filter by the page of the record as well. The language is
a language ID or a
:php-short:`\TYPO3\CMS\Core\Context\LanguageAspect`. Two further optional
arguments of every method choose the workspace and whether deleted
translations are included.
