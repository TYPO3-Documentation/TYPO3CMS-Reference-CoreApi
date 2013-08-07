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

An include-instruction looks like this::

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
FILE     A reference to a file relative to PATH\_site. Cannot contain ".."
         (double periods, back path). Until TYPO3 4.5 the file size had to be
         less than 100 KB; in newer versions this limitation was dropped.

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

