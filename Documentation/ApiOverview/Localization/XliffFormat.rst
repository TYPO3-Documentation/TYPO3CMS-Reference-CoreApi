..  include:: /Includes.rst.txt
..  index:: ! XLIFF
..  _xliff:

============
XLIFF Format
============

The `XML Localization Interchange File Format <https://en.wikipedia.org/wiki/XLIFF>`_
(or XLIFF) is an `OASIS-blessed <https://www.oasis-open.org/committees/xliff>`_
standard format for translations.

In a nutshell, an XLIFF document contains one or more :xml:`<file>` elements.
Each file element usually corresponds to a source (file or database table) and
contains the source of the localizable data. Once translated, the corresponding
localized data is added for one, and only one, locale.

Localizable data is stored in :xml:`<trans-unit>` elements. :xml:`<trans-unit>`
contains a :xml:`<source>` element to store the source text and a
(non-mandatory) :xml:`<target>` element to store the translated text.

The default language is always English, even if you have changed your TYPO3
backend to another language. It is mandatory to set :xml:`source-language="en"`.

..  note::
    Having several :xml:`<file>` elements in the same XLIFF document is not
    supported by the TYPO3 Core.

..  index:: XLIFF; Basics
..  _xliff-basics:

Basics
======

Here is a sample XLIFF file:

..  literalinclude:: _snippets/_example.xlf
    :language: xml
    :caption: EXT:my_extension/Resources/Private/Language/Modules/<file-name>.xlf

The following attributes should be populated properly in order to get the
best support in external translation tools:

:xml:`original` (in :xml:`<file>` tag)
    This property contains the path to the xlf file.

If the external tool used depends on the attribute `resname` you can also
define it. TYPO3 does not consider this attribute.

..  _xliff-translated-file-name:

The translated file is very similar. If the original file was named
:file:`locallang.xlf`, the translated file for German (code "de") will be named
:file:`de.locallang.xlf`.

..  versionchanged:: 12.2

One can use a custom label file, for example, with the locale prefix
:file:`de_CH.locallang.xlf` in an extension next to :file:`de.locallang.xlf` and
:file:`locallang.xlf` (default language English).

When integrators then use "de-CH" within their
:ref:`site configuration <sitehandling>`, TYPO3 first checks if a term is
available in :file:`de_CH.locallang.xlf`, and then automatically falls back to
the non-region-specific "de" label file :file:`de.locallang.xlf` without any
further configuration to TYPO3.

Before TYPO3 v12.2, one has to define a
:ref:`custom language <xliff-translating-languages>`.

..  note::
    The original file must **not** always be in English. You can create files with
    the prefix `en`.

In the file itself, a :xml:`target-language` attribute is added to the
:xml:`<file>` tag to indicate the translation language ("de" in our example).
TYPO3 does not consider the :xml:`target-language` attribute for its own processing
of translations, but the filename prefix instead. The attribute might be useful
though for human translators or tools.
Then, for each :xml:`<source>` tag there is a sibling :xml:`<target>` tag
that contains the translated string.

This is how the translation of our sample file might look like:

..  literalinclude:: _snippets/_example2.xlf
    :language: xml
    :caption: EXT:my_extension/Resources/Private/Language/Modules/<file-name>.xlf

Only one language can be stored per file, and each translation into another
language is placed in an additional file.

..  note::
    The optional :xml:`approved` attribute in a :xml:`<trans-unit>` tag
    indicates whether the translation has been approved by a reviewer.
    :ref:`Crowdin <crowdin-extension-integration>` supports this attribute.
    Currently, only approved translations are exported and available via the
    TYPO3 :ref:`translation server <xliff-translating-servers>`.

    ..  versionchanged:: 12.0
        By default, only translations with no :xml:`approved` attribute or with
        the attribute set to :xml:`yes` are taken into account when parsing XLF
        files. Set the option :ref:`requireApprovedLocalizations
        <typo3ConfVars_sys_lang_requireApprovedLocalizations>` to :php:`false`
        to use translations with the :xml:`approved` attribute set to :xml:`no`.

..  index:: ! Path; EXT:{extkey}/Resources/Private/Language
..  _xliff-files:

File locations and naming
=========================

In the TYPO3 Core, XLIFF files are located in the various system extensions
as needed and are expected to be located in :file:`Resources/Private/Language`.

In :ref:`Extbase <extbase>`, the main file (:file:`locallang.xlf`) is loaded
automatically and is available in the controller and Fluid views without any
further work. Other files must be explicitly referenced with the syntax
:code:`LLL:EXT:extkey/Resources/Private/Language/myfile.xlf:my.label`.

As :ref:`mentioned above <xliff-translated-file-name>`, the translation files
follow the same naming conventions, but are prepended with the language code and
a dot. They are stored alongside the default language files.


.. index:: XLIFF; ID naming
.. _xliff-id-naming:

ID naming
=========

It is recommended to apply the following rules for defining identifiers (the
:xml:`id` attribute).

.. _xliff-id-naming-dots:

Separate by dots
----------------

Use dots to separate logical parts of the identifier.

Good example:

..  code-block:: none

    CType.menuAbstract

Bad examples:

..  code-block:: none

    CTypeMenuAbstract
    CType-menuAbstract


..  index:: XLIFF; Namespace

.. _xliff-id-naming-namespace:

Namespace
---------

Group identifiers together with a useful namespace.

Good example:

..  code-block:: none

    CType.menuAbstract

This groups all available content types for content elements by using
the same prefix ``CType.``.

Bad example:

..  code-block:: none

    menuAbstract

Namespaces should be defined by context.
``menuAbstract.CType`` could also be a reasonable namespace
if the context is about ``menuAbstract``.

.. _xliff-id-naming-lower-camel:

lowerCamelCase
--------------

Generally, lowerCamelCase should be used:

Good example:

..  code-block:: none

    frontendUsers.firstName

..  note::
    For some specific cases where the referenced identifier is in a format
    other than lowerCamelCase, that format can be used:
    For example, database table or column names often are written in snake_case,
    and the XLIFF key then might be something like ``fe_users.first_name``.
