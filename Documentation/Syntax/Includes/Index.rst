.. include:: ../../Includes.txt


.. _includes:

Includes
^^^^^^^^
You can also add include-instructions in TypoScript code. Availability
depends on the context, but it works with TypoScript templates, Page
TSconfig and User TSconfig.

Since TYPO3 version 9 a new syntax for importing external TypoScript files has been introduced,
which acts as a preprocessor before the actual parsing (Condition evaluation) is made.

It's main purpose is ease the use of TypoScript includes and make it easier for integrators and
frontend developers to work with distributed TypoScript files. The syntax is inspired by SASS
imports and works as follows:

.. code-block:: typoscript

	# Import a single file
	@import 'EXT:myproject/TypoScript/Configuration/randomfile.typoscript'

	# Import multiple files in a single directory, sorted by file name
	@import 'EXT:myproject/TypoScript/Configuration/*.typoscript'

	# Import all files in a directory
	@import 'EXT:myproject/TypoScript/Configuration/'

	# It's possible to omit the file ending, then "typoscript" is automatically added
	@import 'EXT:myproject/TypoScript/Configuration/'

The main benefits of `@import` over using `<INCLUDE_TYPOSCRIPT>` (see below) are:
- Less error-prone when adding statements to TypoScript
- Easier to read what should be included (files, folders - instead of `FILE:` and `DIR:` syntax)
- @import is more speaking than a pseudo-XML syntax

The following rules apply:
- If multiple files are found, the file name is important in which order the files (sorted
alphabetically by filename)
- Recursive inclusion of files (@import within @import is possible)
- It is not possible to use a condition as possible with <INCLUDE_TYPOSCRIPT condition=""> as its
sole purpose is to include files, which happens before the actual real condition matching happens,
and the INCLUDE_TYPOSCRIPT condition syntax is a conceptual mistake, and should be avoided.
- Both `<INCLUDE_TYPOSCRIPT>` and `@import` can work side-by-side in the same project
- If a directory is included, it will not include files recursively
- Quoting of the filename is necessary, both double quotes (") and single tickst (') can be used

The syntax is designed to stay, and @import is not intended to be extended with more logic in the
future. However, it may be possible that TypoScript will get more preparsing logic via the @ annotation.

Under the hood, Symfony Finder is used to detect files. This makes globbing (* syntax) possible.


Alternative Syntax
""""""""""""""""""

You can also add include-instructions in another way in TypoScript code.

An include-instruction can e.g. look like this:

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
FILE     A reference to a file relative to :code:`PATH_site`.

         Also paths *relative to the including file* can be
         passed to INCLUDE_TYPOSCRIPT, if the inclusion is called from inside a
         file. These paths start with :code:`./` or :code:`../`. The :code:`./`
         is needed to distinguish them from paths relative to PATH_SITE. This
         mechanism allows simple, nested TypoScript templates that can be moved
         or copied without the need to adapt all includes.

         If you use the a syntax like :file:`EXT:myext/directory/file.txt`
         the file included will be searched for in the extension directory
         of extension "myext", subdirectory :file:`directory/file.txt`.

DIR      This includes all files from a directory relative to :code:`PATH_site`,
         including subdirectories. If the optional property :code:`extensions=".."`
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
         file extension :code:`.typoscript`.
=======  ==========================================================================


.. _includes-conditions:

Conditions
""""""""""

Since TYPO3 CMS 7, it is possible to use conditions on include directives.
The conditions are the same as was presented in the :ref:`previous chapter <conditions>`.
The files or directories will be included only if the condition is met.

Example:

.. code-block:: text

   <INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/user.typoscript" condition="[loginUser = *]">


.. _includes-best-practices:

Best practices
""""""""""""""

The option to filter by extension has been included exactly for the
purpose of covering as many use cases as possible. In TYPO3 CMS we often
have many different ways of configuring something, with pros and cons
and the extended inclusion command serves this purpose of letting you
organize your files with different directories using whichever extension
fits your needs better (e.g., :code:`.typoscript`) and/or filter by extension (e.g.,
because you may have :code:`.typoscript` and :code:`.txt` in the directory or because you prefer
having :code:`.typoscript<something>` as extension).

It is recommended to separate files with different directories:

* For TSconfig code use a directory called TSconfig/, possibly with
  subdirectories named Page/ for Page TSconfig and User/ for
  User TSconfig.
* For TypoScript template code, use a directory named
  TypoScript/.

However, we understand that filtering by extension could make sense in
some situations and this is why there is this additional option.

