.. include:: ../../Includes.txt


.. _xliff:

Introduction to XLIFF
---------------------

The `XML Localisation Interchange File Format <http://en.wikipedia.org/wiki/XLIFF>`_
(or XLIFF) is an `OASIS-blessed <http://www.oasis-open.org/committees/xliff>`_
standard format for translations.

.. note::

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


.. _xliff-basics:

Basics
^^^^^^

Here is a sample XLIFF file:

.. code-block:: xml

   <?xml version="1.0" encoding="UTF-8"?>
   <xliff version="1.0" xmlns="urn:oasis:names:tc:xliff:document:1.1">
      <file source-language="en" datatype="plaintext" original="messages" date="2011-10-18T18:20:51Z" product-name="my-ext">
         <header/>
         <body>
            <trans-unit id="headerComment" xml:space="preserve">
               <source>The default Header Comment.</source>
            </trans-unit>
            <trans-unit id="generator" xml:space="preserve">
               <source>The "Generator" Meta Tag.</source>
            </trans-unit>
         </body>
      </file>
   </xliff>

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
      <file source-language="en" target-language="de" datatype="plaintext" original="messages" date="2011-10-18T18:20:51Z" product-name="my-ext">
         <header/>
         <body>
            <trans-unit id="headerComment" xml:space="preserve">
               <source>The default Header Comment.</source>
               <target>Der Standard-Header-Kommentar.</target>
            </trans-unit>
            <trans-unit id="generator" xml:space="preserve">
               <source>The "Generator" Meta Tag.</source>
               <target>Der "Generator"-Meta-Tag.</target>
            </trans-unit>
         </body>
      </file>
   </xliff>

Contrary to "locallang XML" files, only one language can be stored per file.
Each translation in a different language goes to an additional file.


.. _xliff-files:

File locations and naming
^^^^^^^^^^^^^^^^^^^^^^^^^

The files follow the same naming conventions as the "locallang XML" files, except
they use extension "xlf" instead of "xml".

In the TYPO3 Core, XLIFF files are located in the various system extensions
as needed. The system extension "lang" provides several general purpose files
plus the classes related to the localization API.

In Extbase-based extensions, XLIFF files are expected to be located in
:file:`Resources/Private/Language`. The main file (:file:`locallang.xlf`) will
be loaded automatically and available in the controller and Fluid views
without further work needed. Other files will need to be referred to
explicitly.

As mentioned above, the translation files follow the same naming conventions, but
are prepended with the language code and a dot. They are stored alongside the default
language files.
