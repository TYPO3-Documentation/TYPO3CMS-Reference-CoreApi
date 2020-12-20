.. include:: /Includes.rst.txt
.. index:: ! XLIFF
.. _xliff:

============
XLIFF Format
============

The `XML Localisation Interchange File Format <http://en.wikipedia.org/wiki/XLIFF>`_
(or XLIFF) is an `OASIS-blessed <http://www.oasis-open.org/committees/xliff>`_
standard format for translations.

In a nutshell an XLIFF document contains one or more :code:`<file>` elements. Each file
element usually corresponds to a source (file or database table) and contains the source
of the localizable data. Once translated, the corresponding localized data for one, and
only one, locale is added.

Localizable data are stored in :code:`<trans-unit>` elements. The :code:`<trans-unit>` contains
a :code:`<source>` element to store the source text and a (non-mandatory) :code:`<target>`
element to store the translated text.

Note that having several :code:`<file>` elements in the same XLIFF document is not
supported by the TYPO3 CMS Core.

Keep in mind that the default language is always considered to be english,
even when you have changed your typo3 backend to another language, so
source-language must always be `source-language="en"`.


.. index:: XLIFF; Basics
.. _xliff-basics:

Basics
======

Here is a sample XLIFF file:

.. code-block:: xml

   <?xml version="1.0" encoding="UTF-8"?>
   <xliff version="1.0" xmlns="urn:oasis:names:tc:xliff:document:1.1">
      <file source-language="en" datatype="plaintext" original="EXT:my_ext/Resources/Private/Language/Modules/<ffile-name>.xlf" date="2011-10-18T18:20:51Z" product-name="my_ext">
         <header/>
         <body>
            <trans-unit id="headerComment" resname="headerComment">
               <source>The default Header Comment.</source>
            </trans-unit>
            <trans-unit id="generator" resname="generator">
               <source>The "Generator" Meta Tag.</source>
            </trans-unit>
         </body>
      </file>
   </xliff>

.. note::

   The following properties should be filled properly to get best support in external translation tools:

   `original`
      This property contains the path to the xlf file.

   `resname`
      Its content is shown to translators. It should be a copy of the property `id`.


The translated file is very similar. If the original file was named
:file:`locallang.xlf`, the translated file for German (code "de") will
be named :file:`de.locallang.xlf`. Note that the original file must always be in english,
so it is not allowed to create a file with the prefix "en" e.g. :file:`en.locallang.xlf`.
Inside the file itself, a :code:`<target-language>` attribute is added in the :code:`<file>` tag to
indicate the translation language ("de" in our example). Then for each
:code:`<source>` tag there's a sibling :code:`<target>` tag containing the
translated string.

Here is what the translation of our sample file could look like:

.. code-block:: xml

   <xliff version="1.0" xmlns="urn:oasis:names:tc:xliff:document:1.1">
      <file source-language="en" target-language="de" datatype="plaintext" original="EXT:my_ext/Resources/Private/Language/Modules/<ffile-name>.xlf" date="2011-10-18T18:20:51Z" product-name="my_ext">
         <header/>
         <body>
            <trans-unit id="headerComment" resname="headerComment">
               <source>The default Header Comment.</source>
               <target>Der Standard-Header-Kommentar.</target>
            </trans-unit>
            <trans-unit id="generator" resname="generator">
               <source>The "Generator" Meta Tag.</source>
               <target>Der "Generator"-Meta-Tag.</target>
            </trans-unit>
         </body>
      </file>
   </xliff>

Only one language can be stored per file and each translation in a different language
goes to an additional file.


.. index:: ! Path; EXT:{extkey}/Resources/Private/Language
.. _xliff-files:

File locations and naming
=========================

In the TYPO3 Core, XLIFF files are located in the various system extensions
as needed and are expected to be located in :file:`Resources/Private/Language`.

In Extbase, the main file (:file:`locallang.xlf`) will be loaded automatically and
available in the controller and Fluid views without further work needed. Other files will
need to be referred to explicitly using the :code:`EXT:LLL:extkey/path/to/file:my.label` syntax.

As mentioned above, the translation files follow the same naming conventions, but
are prepended with the language code and a dot. They are stored alongside the default
language files.


.. index:: XLIFF; ID naming
.. _xliff-id-naming:

ID naming
=========

There is no strict rule or guideline in place for defining identifiers
(the ``id`` attribute).
Still it is best practice to follow these rules:

Separate by Dots
----------------

Use dots to separate logical parts of the identifier.

Good example:

.. code-block:: none

   CType.menu_abstract

Bad examples:

.. code-block:: none

    CType_menu_abstract
    CType-menu_abstract


.. index:: XLIFF; Namespace

Namespace
---------

Group identifiers together with a useful namespace.

Good example:

.. code-block:: none

   CType.menu_abstract

This groups all available content types for content elements by using
the same prefix ``CType.``.

Bad example:

.. code-block:: none

    menu_abstract

Namespaces should be defined by context.
``menu_abstract.CType`` could also be a reasonable namespace
if the context is about ``menu_abstract``.

lowerCamelCase
--------------

Generally, lowerCamelCase should be used:

Good example:

.. code-block:: none

   frontendUsers.firstName

Exceptions:

* For some specific cases where the referenced identifier is in a format
  other than lowerCamelCase, that format can be used:
  For example, database table or column names often are written in snake_case,
  and the XLIFF key then might be something like ``fe_users.first_name``.
