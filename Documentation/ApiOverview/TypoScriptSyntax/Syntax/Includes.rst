.. include:: ../../../Includes.txt


.. _typoscript-syntax-includes:

Includes
^^^^^^^^
You can also add include-instructions in TypoScript code. Availability
depends on the context, but it works with TypoScript templates, Page
TSconfig and User TSconfig.

Alternative, traditional Syntax
"""""""""""""""""""""""""""""""

A traditional include-instruction will work as well and for example looks like
this:

.. code-block:: typoscript

   <INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/html/mainmenu_typoscript.txt">

- It must have its own line in the TypoScript template, otherwise it is
  not recognized.

- It is processed BEFORE any parsing of TypoScript (contrary to
  conditions) and therefore does not care about the nesting of
  confinements within the TypoScript code.

The "source" parameter points to the source of the included content.
The string before the first ":" (in the example it is the word "FILE")
will determine which source the content is coming from. These options
are available:

=======  ==========================================================================
Option   Description
=======  ==========================================================================
FILE     A reference to a file relative to :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()`.

         Also paths *relative to the including file* can be
         passed to INCLUDE_TYPOSCRIPT, if the inclusion is called from inside a
         file. These paths start with :file:`./` or :file:`../`. The :file:`./`
         is needed to distinguish them from paths relative to :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()`. This
         mechanism allows simple, nested TypoScript templates that can be moved
         or copied without the need to adapt all includes.

         If you use a syntax like :file:`EXT:myext/directory/file.txt`
         the file included will be searched for in the extension directory
         of extension "myext", subdirectory :file:`directory/file.txt`.

DIR      This includes all files from a directory relative to :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()`,
         including subdirectories. If the optional property :file:`extensions="..."`
         is provided, only files with these file extensions are included;
         multiple extensions are separated by comma. This allows e.g. to include
         both setup and constants from the same directory tree, using different
         file extensions for both.

         Files are included in alphabetical. Also files are included first,
         then directories.

         Example:

         .. code-block:: typoscript

            <INCLUDE_TYPOSCRIPT: source="DIR:fileadmin/templates/" extensions="typoscript">

         This includes all those files from the directory
         :file:`fileadmin/templates/` and from subdirectories, which have the
         file extension :file:`.typoscript`.
=======  ==========================================================================


.. _typoscript-syntax-includes-conditions:

Conditions
""""""""""

Since TYPO3 CMS 7, it is possible to use conditions on include directives.
The conditions are the same as was presented in the :ref:`previous chapter <typoscript-syntax-conditions>`.
The files or directories will be included only if the condition is met.

Example:

.. code-block:: text

   <INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/user.typoscript" condition="[loginUser = *]">


.. _typoscript-syntax-includes-best-practices:

Best practices
""""""""""""""

The option to filter by extension has been included exactly for the
purpose of covering as many use cases as possible. In TYPO3 CMS we often
have many different ways of configuring something, with pros and cons
and the extended inclusion command serves this purpose of letting you
organize your files with different directories using whichever extension
fits your needs better (e.g., :file:`.typoscript`) and/or filter by extension (e.g.,
because you may have :file:`.typoscript` and :file:`.txt` in the directory or because you prefer
having :file:`.typoscript<something>` as extension).

It is recommended to separate files with different directories:

* For TSconfig code use a directory called TSconfig/, possibly with
  subdirectories named Page/ for Page TSconfig and User/ for
  User TSconfig.
* For TypoScript template code, use a directory named
  TypoScript/.

However, we understand that filtering by extension could make sense in
some situations and this is why there is this additional option.

