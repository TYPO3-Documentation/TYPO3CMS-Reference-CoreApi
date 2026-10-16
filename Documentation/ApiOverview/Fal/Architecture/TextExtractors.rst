:navigation-title: Text extractors

..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Text extractors
..  _fal-text-extractors:

====================================================
Text extractors for the file abstraction layer (FAL)
====================================================

A text extractor returns the text content of a file, for example for a search
index. TYPO3 Core ships
:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\PlainTextExtractor` for
files of the MIME type `text/plain`. Extensions can add text extractors for
other file types.

..  contents:: Table of contents

..  _fal-text-extractors-register:

Register a text extractor with `#[AsTextExtractor]`
===================================================

..  versionchanged:: 15.0
    :changelog: breaking-110286-1784879763

    Text extractors are registered as services. A registration with
    :php:`TextExtractorRegistry->registerTextExtractor()` in
    :file:`ext_localconf.php` has no effect anymore. The methods of
    :php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorInterface`
    are now strictly typed. To support TYPO3 v14 as well, keep the
    registration in :file:`ext_localconf.php` and add the attribute.

A text extractor implements
:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorInterface`
and is registered with the PHP attribute
:php-short:`\TYPO3\CMS\Core\Attribute\AsTextExtractor`:

..  literalinclude:: _TextExtractors/_MarkdownTextExtractor.php
    :caption: EXT:my_extension/Classes/Resource/TextExtraction/MarkdownTextExtractor.php

Method :php:`canExtractText()`
    Return :php:`true` if the extractor can read the given file.

Method :php:`extractText()`
    Return the text content of the file.

A text extractor is a service, so it can use dependency injection in its
constructor.

..  _fal-text-extractors-priority:

Priority of text extractors
===========================

TYPO3 asks the text extractors in the order of their priority, the highest
first. The first extractor that can read the file extracts the text. The
extractors of TYPO3 Core have the priority `0`, so an extractor with a higher
priority takes precedence. The order of extractors with the same priority is
not defined. Give each extractor its own priority if the order matters.

..  _fal-text-extractors-service-tag:

Register a text extractor with the service tag `fal.text_extractor`
===================================================================

Instead of the attribute, the service tag :yaml:`fal.text_extractor` can be
used:

..  literalinclude:: _TextExtractors/_Services.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

..  _fal-text-extractors-use:

Extract the text of a file
==========================

:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorRegistry`
returns the first text extractor that can read a file, or `null` if there is
none:

..  literalinclude:: _TextExtractors/_FileContentIndexer.php
    :caption: EXT:my_extension/Classes/Search/FileContentIndexer.php
