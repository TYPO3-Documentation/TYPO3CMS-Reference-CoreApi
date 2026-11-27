:navigation-title: Text extractors

..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Text extractors
..  _fal-text-extractors:

====================================================
Text extractors for the file abstraction layer (FAL)
====================================================

A text extractor returns the text content of a file, for example for a search
index, together with the title, the description, and the keywords that it
finds in the file. TYPO3 Core ships
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

..  versionadded:: 15.0
    :changelog: feature-110775-1790261961

    Text extractors can implement
    :php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\StructuredTextExtractorInterface`.

A text extractor implements
:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\StructuredTextExtractorInterface`
and is registered with the PHP attribute
:php-short:`\TYPO3\CMS\Core\Attribute\AsTextExtractor`:

..  literalinclude:: _TextExtractors/_MarkdownStructuredTextExtractor.php
    :caption: EXT:my_extension/Classes/Resource/TextExtraction/MarkdownTextExtractor.php

Method :php:`getSupportedMimeTypes()`
    Return the MIME types, in lowercase, that the extractor can read. TYPO3
    selects the extractor by the MIME type of a file, not by its file
    extension. An extractor that needs an external tool returns an empty
    list as long as the tool is not available.

Method :php:`extractStructuredText()`
    Return the text of the file as
    :php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\ExtractedText`,
    with the title, the description, and the keywords, if the file has them.

The extractor gets a
:php-short:`\TYPO3\CMS\Core\SystemResource\Type\SystemResourceInterface`,
so it reads files of a FAL storage as well as files of an extension or other
public files outside of a storage.

A file type that PHP detects differently depending on the system, such as a
Word document detected as `application/zip`, is mapped to one MIME type by
`mimeTypeCompatibility <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-fileinfo-mimetypecompatibility>`_.
The extractor declares only that MIME type, such as
`application/vnd.openxmlformats-officedocument.wordprocessingml.document`.

A text extractor is a service, so it can use dependency injection in its
constructor.

..  _fal-text-extractors-file-only:

Text extractors for FAL files only
----------------------------------

A text extractor that implements
:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorInterface`
reads files of a FAL storage only, and provides only the text:

..  literalinclude:: _TextExtractors/_MarkdownTextExtractor.php
    :caption: EXT:my_extension/Classes/Resource/TextExtraction/MarkdownTextExtractor.php

Method :php:`canExtractText()`
    Return :php:`true` if the extractor can read the given file.

Method :php:`extractText()`
    Return the text content of the file.

Only an extractor of this interface is returned by
:php:`TextExtractorRegistry->getTextExtractor()`. A new extractor implements
both interfaces only if code that calls this method should find it, as the
extractors of TYPO3 Core do.

..  _fal-text-extractors-priority:

Priority of text extractors
===========================

TYPO3 asks the text extractors in the order of their priority, the highest
first, whichever interface they implement. The first extractor that can read
the file extracts the text: one that supports the MIME type of the file, or
one whose :php:`canExtractText()` returns :php:`true`. The
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

:php:`TextExtractorRegistry->extract()` extracts the text of a file with the
first text extractor that can read it, or returns `null` if there is none:

..  literalinclude:: _TextExtractors/_FileContentIndexer.php
    :caption: EXT:my_extension/Classes/Search/FileContentIndexer.php

The text of an extractor that implements only
:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorInterface`
comes as
:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\ExtractedText` as
well, with an empty title, description, and keywords.

:php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorRegistry`
also has these methods:

Method :php:`findTextExtractor()`
    Returns the text extractor that :php:`extract()` would use, or `null`.

Method :php:`getSupportedFileExtensions()`
    Returns the file extensions of the MIME types that the extractors
    declare, for example to offer them in a search form.

Method :php:`getTextExtractor()`
    Returns the first extractor of
    :php-short:`\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorInterface`
    that can read a FAL file. Use :php:`extract()` instead, which also finds
    the other extractors.
