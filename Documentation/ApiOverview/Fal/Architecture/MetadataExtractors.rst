:navigtation-title: Metadata extractors

..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Metadata extractors
..  _fal-metadata-extractors:

========================================================
Metadata extractors for the file abstraction layer (FAL)
========================================================

..  deprecated:: 14.0
    Registration of Metadata extractors will happen automatically when the
    required interface :php-short:`TYPO3\CMS\Core\Resource\Index\ExtractorInterface`
    is implemented by a class. No further registration is necessary.

    The method :php:`TYPO3\CMS\Core\Resource\Index\ExtractorRegistry::registerExtractionService()`
    has been marked as deprecated, the call in :file:`ext_localconf.php` can be removed without substitution.

Metadata extractors are service classes that are automatically
executed whenever an asset / file is added to the FAL storage,
or FAL indexing is executed.

Registration of Metadata extractors will happen automatically when the required interface
:php:`TYPO3\CMS\Core\Resource\Index\ExtractorInterface` is implemented by the class,
utilizing autoconfigure tagging by the Symfony Dependence Injection framework.

..  note::
    An example is missing, use the edit on github button to provide an example.
