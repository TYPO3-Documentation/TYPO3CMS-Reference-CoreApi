.. include:: /Includes.rst.txt
.. index:: TypoScript; Includes
.. _typoscript-syntax-includes:

============
File imports
============

..  versionchanged:: 14.0
    The old school :typoscript:`<INCLUDE_TYPOSCRIPT:` syntax has been deprecated
    with version 13.4 and was removed with TYPO3 v14.0.
    See :ref:`t3coreapi/13:typoscript-syntax-includes-migration`.

To structure and reuse single TypoScript snippets and not stuffing everything
into one file or record, the syntax allows loading TypoScript content from sub files.

The keyword :typoscript:`@import` is a syntax construct and
thus available in both frontend TypoScript and backend TSconfig.

:typoscript:`@import` allows including additional files using wildcards on the file
level. Wildcards in paths are not allowed.

The TypoScript parser allows to place :typoscript:`@import` within condition
bodies, which allows conditional imports with :typoscript:`@import`.

:typoscript:`@import` is not allowed to be placed within code blocks
and breaks any curly braces level, resetting current scope
to top level.

.. _typoscript-syntax-import:

@import
=======

This keyword allows including files inspired by a syntax similar to :code:`SASS`.
It is restricted, but still allows wildcards on file level. Single files *must* end
with :file:`.typoscript` if included in frontend Typoscript. In backend TSconfig,
single files *should* end with :file:`.tsconfig`, but *may* end with
:typoscript:`.typoscript` as well (for now).

The include logic is a bit more restrictive with TYPO3 v12, previous versions
have been slightly more relaxed in this regard. See
:doc:`this changelog <ext_core:Changelog/12.0/Breaking-97816-TypoScriptSyntaxChanges>`
for more details.

The following rules apply:

* Multiple files are imported in alphabetical order.
  If a special loading order is desired it is common to prefix the filenames with
  numbers that increase for files that shall be loaded later.

* Recursion is allowed: Imported files can have :typoscript:`@import` statements.

* .. versionchanged:: 12.0

  It is allowed to put :typoscript:`@import` within a condition. This example imports
  the additional file only if a frontend user is logged in:

  .. code-block:: typoscript

      [frontend.user.isLoggedIn]
          @import './userIsLoggedIn.typoscript'
      [END]

* Directory imports are not recursive, meaning that a directory import does
  not automatically travel down its subdirectories.

* Quoting the filename is necessary with the new syntax. Either double quotes
  (") or single quotes (') can be used.

* Wildcards :typoscript:`*` are only allowed on file level, not on directory level.
  Only a single wildcard character is allowed.

* Includes relative to the current file location are allowed using :typoscript:`./`
  as prefix.

* Includes must start with :typoscript:`EXT:` if not relative. Loading files
  outside of extensions is not possible.

* Directory traversal using :typoscript:`../` is not allowed.

Some examples:

.. code-block:: typoscript

    # Import a single file
    @import 'EXT:my_extension/Configuration/TypoScript/randomfile.typoscript'

    # Import multiple files in a single directory, sorted by file name
    @import 'EXT:my_extension/Configuration/TypoScript/*.typoscript'

    # It's possible to omit the file ending. For frontend TypoScript, ".typoscript" is
    # appended automatically, backend TSconfig allows both ".typoscript" and ".tsconfig"
    @import 'EXT:my_extension/Configuration/TypoScript/'

    # Import files starting with "foo", ending with ".typoscript" (frontend)
    @import 'EXT:my_extension/Configuration/TypoScript/foo*'

    # Import files ending with ".setup.typoscript"
    @import 'EXT:my_extension/Configuration/TypoScript/*.setup.typoscript'

    # Import "bar.typoscript" relative to current file
    @import './bar.typoscript'

    # Import all ".setup.typoscript" files in sub directory relative to current file
    @import './subDirectory/*.setup.typoscript'


.. _typoscript-syntax-includes-alternatives:

Alternatives to using file imports
==================================

The following features can make file inclusion unnecessary:

*   :ref:`Automatic global inclusion of user TSconfig of extensions <t3tsconfig:usersettingdefaultusertsconfig>`
*   :ref:`Automatic global inclusion of page TSconfig of extensions <t3tsconfig:pagesettingdefaultpagetsconfig>`
*   :ref:`Automatic page TSconfig on site level <t3tsconfig:include-static-page-tsconfig-per-site>`
*   :ref:`TypoScript provider for sites and sets <site-sets-typoscript>`
    automatically loads TypoScript per site when the site set is included in the
    site configuration.
