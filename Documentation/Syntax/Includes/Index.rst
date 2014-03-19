.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _includes:

Includes
^^^^^^^^

You can also add include-instructions in TypoScript code. Availability
depends on the context, but it works with TypoScript templates, Page
TSconfig and User TSconfig.

An include-instruction can e.g. look like this::

   <INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/html/mainmenu_typoscript.txt">

- It must have its own line in the TypoScript template, otherwise it is
  not recognized.

- It is processed BEFORE any parsing of TypoScript (contrary to
  conditions) and therefore does not care about the nesting of
  confinements within the TypoScript code.

The "source" parameter points to the source of the included content.
The string before the first ":" (in the example it is the word "FILE")
will determine which source the content is coming from. These options
are available:


.. ### BEGIN~OF~SIMPLE~TABLE ###

=======  ========================================================================
Option   Description
=======  ========================================================================
FILE     A reference to a file relative to PATH\_site. Until TYPO3 4.5 the file
         size had to be less than 100 KB; in newer versions this limitation was
         dropped.

         Since TYPO3 6.2 also paths *relative to the including file* can be
         passed to INCLUDE_TYPOSCRIPT, if the inclusion is called from inside a
         file. These paths start with "./" or "../". The "./" is needed to
         distinguish them from paths relative to PATH_SITE. This mechanism
         allows simple, nested TypoScript templates that can be moved or copied
         without the need to adapt all includes.

         If you prefix the relative path with such as
         "EXT:myext/directory/file.txt" then the file included will be searched
         for in the extension directory of extension "myext", subdirectory
         "directory/file.txt".

DIR      This includes all files from a directory relative to PATH\_site,
         including subdirectories. If the optional property ``extensions=".."``
         is provided, only files with these file extensions are included;
         multiple extensions are separated by comma. This allows e.g. to include
         both setup and constants from the same directory tree, using different
         file extensions for both.

         The order, in which files are included, is alphabetically: First files,
         then directories.

         Example::

            <INCLUDE TYPOSCRIPT: source="DIR:fileadmin/templates/" extensions="ts">

         This includes all those files from the directory fileadmin/templates/
         and from subdirectories, which have the file extension ".ts".
=======  ========================================================================

.. ###### END~OF~SIMPLE~TABLE ######


.. _includes-best-practices:

Best practices
""""""""""""""

The option to filter by extension has been included exactly for the
purpose of covering as many use cases as possible. In TYPO3 we often
have many different ways of configuring something, with pros and cons
and the extended inclusion command serves this purpose of letting you
organize your files with different directories using whichever extension
fits your needs better (e.g., ".ts") and/or filter by extension (e.g.,
because you may have .ts and .txt in the directory or because you prefer
having .ts<something> as extension).

It is recommended to separate files with different directories:

* For TSconfig code use a directory called TSconfig/, possibly with
  subdirectories named Page/ for Page TSconfig and User/ for
  User TSconfig.
* For TypoScript template code, use a directory named
  TypoScript/.

However, we understand that filtering by extension could make sense in
some situations and this is why there is this additional option.

