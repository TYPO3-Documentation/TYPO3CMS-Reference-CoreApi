:navigtation-title: Metadata extractors

..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Metadata extractors
..  _fal-metadata-extractors:

========================================================
Metadata extractors for the file abstraction layer (FAL)
========================================================

..  deprecated:: 14.0
    If a class implements
    :php-short:`TYPO3\CMS\Core\Resource\Index\ExtractorInterface`,
    registration of Metadata extractors happens automatically. No further
    registration is necessary.

    The method :php:`TYPO3\CMS\Core\Resource\Index\ExtractorRegistry::registerExtractionService()`
    has been marked as deprecated. The call in :file:`ext_localconf.php` can be
    removed.

Metadata extractors are service classes that are automatically
executed whenever an asset / file is added to FAL storage
or when FAL indexing is executed.

If :php:`TYPO3\CMS\Core\Resource\Index\ExtractorInterface` is implemented by a
class, registration of Metadata extractors happens automatically. This is due to
autoconfigure tagging by the Symfony Dependence Injection framework.

..  note::
    Unfortunately, we don't have a current example. Please use the "Edit on GitHub"
    button to provide one.
