:navigation-title: XLIFF format

..  include:: /Includes.rst.txt
..  index:: ! XLIFF
..  _xliff:

================================
Translation files (XLIFF format)
================================

..  versionadded:: 14.0

    TYPO3 supports both XLIFF 1.2 and XLIFF 2.x translation file formats.
    The loader automatically detects which version is used and parses it
    accordingly.

Use **XLIFF 2.x** for all new projects (introduced with TYPO3 v14).
Each label file is written in English (`srcLang="en"`) and stored in
`EXT:my_ext/Resources/Private/Language/`.
Translations are stored in separate files such as `de.locallang.xlf`.
TYPO3 considers only *approved* translations (`state="reviewed"` or `state="final"`) by default.

To also load unapproved strings (for example `state="translated"`),
set
`$GLOBALS['TYPO3_CONF_VARS']['LANG']['requireApprovedLocalizations'] <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-lang-requireapprovedlocalizations>`_
to :php:`false`.

..  contents:: Table of contents

..  _xliff-about:

About the XLIFF standard
========================

The `XML Localization Interchange File Format <https://en.wikipedia.org/wiki/XLIFF>`_
(or **XLIFF**) is an `OASIS standard <https://www.oasis-open.org/committees/xliff>`_
format for structured translations.

An XLIFF document contains one or more :xml:`<file>` elements (TYPO3 supports
exactly one per file). Each :xml:`<file>` contains translation units that hold
a :xml:`<source>` text and optionally a :xml:`<target>` translation.

The default language is always English (`en`).
Set :xml:`srcLang="en"` for XLIFF 2.x or :xml:`source-language="en"` for 1.2.

..  note::
    Having several :xml:`<file>` elements in one document is not supported by TYPO3.

..  index:: XLIFF; Examples
..  _xliff-examples:

XLIFF file examples
===================

..  tabs::

    ..  group-tab:: XLIFF 2.x (recommended)

        ..  versionadded:: 14.0

        ..  literalinclude:: _snippets/_example_xliff_2.0.xlf
            :language: xml
            :caption: EXT:my_ext/Resources/Private/Language/locallang.xlf

        XLIFF 2.x is the preferred format. Each :xml:`<unit>` contains a
        :xml:`<segment>` with :xml:`<source>` and optionally :xml:`<target>`.

    ..  group-tab:: XLIFF 1.2 (legacy)

        ..  literalinclude:: _snippets/_example_xliff_1.2.xlf
            :language: xml
            :caption: EXT:my_ext/Resources/Private/Language/locallang.xlf

        This format remains supported for backward compatibility.

The following attributes should be populated properly to get the best support
in external translation tools:

:xml:`original` (in :xml:`<file>` tag)
    Contains the path to the XLF file within the extension.

If the external tool depends on the attribute :xml:`resname`, you can also
define it. TYPO3 ignores this attribute internally.

..  _xliff-translated-file-name:

Translated XLIFF files and fallbacks
====================================

Translated files use the same name as the English source but are prefixed with
the locale code, for example:

:file:`de.locallang.xlf`
:file:`de_CH.locallang.xlf`

TYPO3 automatically falls back from `de_CH` to `de` if needed.

..  note::
    The original file must always be in English. Do **not** create files with
    the prefix `en`.

The translation language is also defined in the file header:
:xml:`trgLang="de"` (XLIFF 2.0) or :xml:`target-language="de"` (XLIFF 1.2).

..  _xliff-sample-translations:

Sample XLIFF translation files
==============================

..  tabs::

    ..  group-tab:: XLIFF 2.0

        ..  versionadded:: 14.0

        ..  literalinclude:: _snippets/_example_xliff_2.0.xlf
            :language: xml
            :caption: EXT:my_extension/Resources/Private/Language/de.locallang.xlf

        In XLIFF 2.0, the approval status of a translation is defined by the
        :xml:`state` attribute on the :xml:`<target>` element.
        Common values are:

        `initial`
            Translation not yet started.

        `translated`
            Translation provided but not yet reviewed.

        `reviewed`
            Translation reviewed and approved.

        `final`
            Final, approved translation ready for use.

        TYPO3 treats translations with :xml:`state="reviewed"` or
        :xml:`state="final"` as approved.

    ..  group-tab:: XLIFF 1.2

        ..  literalinclude:: _snippets/_example_xliff_1.2.xlf
            :language: xml
            :caption: EXT:my_extension/Resources/Private/Language/de.locallang.xlf

        In XLIFF 1.2, the optional :xml:`approved` attribute in a
        :xml:`<trans-unit>` tag indicates whether a translation has been
        reviewed and approved, for example :xml:`approved="yes"`.

Only one language can be stored per file; each translation into another
language is stored in an additional file.

By default, TYPO3 considers only approved translations for both XLIFF 1.2 and 2.x:

-   XLIFF 1.2: :xml:`approved="yes"` or missing attribute
-   XLIFF 2.0: :xml:`state="reviewed"` or :xml:`state="final"`

To also include unapproved translations
(for example :xml:`approved="no"` or :xml:`state="translated"`),
set the option
`$GLOBALS['TYPO3_CONF_VARS']['LANG']['requireApprovedLocalizations']
<https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-lang-requireapprovedlocalizations>`_
to :php:`false`.

..  index:: ! Path; EXT:{extkey}/Resources/Private/Language
..  _xliff-files:

Where to store XLIFF files
==========================

In the TYPO3 Core, XLIFF files are located in the various system extensions
and are expected to be stored in :file:`Resources/Private/Language`.

In :ref:`Extbase <extbase>`, the main file (:file:`locallang.xlf`) is loaded
automatically and is available in the controller and Fluid views without any
further work. Other files must be explicitly referenced with the syntax
`LLL:EXT:extkey/Resources/Private/Language/myfile.xlf:my.label`.

As :ref:`mentioned above <xliff-translated-file-name>`, translation files
follow the same naming conventions but are prefixed with the language code and
stored alongside the default language files.

..  index:: XLIFF; ID naming
..  _xliff-id-naming:

Naming XLIFF IDs
================

It is recommended to apply the following rules for defining identifiers (the
:xml:`id` attribute).

.. _xliff-id-naming-dots:

Separate XLIFF IDs by dots
--------------------------

Use dots to separate logical parts of the identifier.

Good example:

..  code-block:: none

    CType.menuAbstract

Bad examples:

..  code-block:: none

    CTypeMenuAbstract
    CType-menuAbstract

.. _xliff-id-naming-namespace:

Namespace convention for XLIFF IDs
----------------------------------

Group identifiers together with a useful namespace.

Good example:

..  code-block:: none

    CType.menuAbstract

This groups all available content types for content elements by using
the same prefix `CType.`.

Bad example:

..  code-block:: none

    menuAbstract

Namespaces should be defined by context.
`menuAbstract.CType` could also be a reasonable namespace
if the context is about `menuAbstract`.

.. _xliff-id-naming-lower-camel:

Use lowerCamelCase for XLIFF IDs
--------------------------------

Generally, lowerCamelCase should be used:

Good example:

..  code-block:: none

    frontendUsers.firstName

For some specific cases where the referenced identifier is in a format
other than lowerCamelCase, that format can be used:

For example, database table or column names often are written in snake_case,
and the XLIFF key then might be something like `fe_users.first_name`.
