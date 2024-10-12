.. include:: /Includes.rst.txt
.. index:: TypoScript; Includes
.. _typoscript-syntax-includes:

============
File imports
============

To structure and reuse single TypoScript snippets and not stuffing everything
into one file or record, the syntax allows loading TypoScript content from sub files.

The two keywords are :typoscript:`@import` and the old school
:typoscript:`<INCLUDE_TYPOSCRIPT:`. They are a syntax construct and
thus available in both frontend Typoscript and backend TSconfig.

Both :typoscript:`@import` and :typoscript:`<INCLUDE_TYPOSCRIPT:` allow
including additional files using wildcards. :typoscript:`@import` is a bit
more restricted, though. The TYPO3 Core strives to get rid of
:typoscript:`<INCLUDE_TYPOSCRIPT:` mid-term, and :typoscript:`@import` has
been tuned with TYPO3 v12 to show good performance metrics. Integrators
should prefer :typoscript:`@import` over :typoscript:`<INCLUDE_TYPOSCRIPT:`
since it is best practice and more future proof.

The TypoScript parser allows to place :typoscript:`@import` and
:typoscript:`<INCLUDE_TYPOSCRIPT:` within condition bodies, which obsoletes the
:typoscript:`condition` keyword of :typoscript:`<INCLUDE_TYPOSCRIPT:` and allows conditional
imports with :typoscript:`@import`.

Neither :typoscript:`@import` nor :typoscript:`<INCLUDE_TYPOSCRIPT:` are allowed
to be placed within code blocks.

..  versionchanged:: 12.2
    :typoscript:`@import` and :typoscript:`<INCLUDE_TYPOSCRIPT:` basically
    break any curly braces level, resetting current scope to top level. While
    inclusion of files has never been documented to be valid within braces
    assignments, it still worked until TYPO3 v11. This is now disallowed and
    must not be used anymore. For example, a construct like this is **invalid**:

    ..  code-block:: typoscript

        page = PAGE
        page {
          # This import won't work!
          @import 'EXT:my_extension/Configuration/TypoScript/bar.typoscript'
          20 = TEXT
          20.value = bar
        }

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

* The :typoscript:`@import` statement does not take a condition clause as the old
  :typoscript:`<INCLUDE_TYPOSCRIPT condition="">` statement did. That kind of condition
  should be considered a conceptual mistake. It should not be used.

* .. versionchanged:: 12.0

  It is allowed to put :typoscript:`@import` within a condition. This example imports
  the additional file only if a frontend user is logged in:

  .. code-block:: typoscript

      [frontend.user.isLoggedIn]
          @import './userIsLoggedIn.typoscript'
      [END]

* Both the old syntax :typoscript:`<INCLUDE_TYPOSCRIPT>` and the new one :typoscript:`@import`
  can be used at the same time.

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


.. index:: TypoScript; Includes by conditions
.. _typoscript-syntax-includes-conditions:
.. _typoscript-syntax-includes-best-practices:

<INCLUDE_TYPOSCRIPT:
====================

This traditional include instruction works as well. It is more clumsy and permissive,
does not follow best practices. It should be avoided as of TYPO3 v12 and is likely
to be deprecated with TYPO3 v13. It looks like this:

.. code-block:: typoscript

   <INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/myMenu.typoscript">

More details:

* Keyword "FILE":

  A reference to a single file relative to :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()`.

  Paths relative to the including file can be used, if the inclusion is called
  from inside a file. These paths start with :file:`FILE:./`. This allows simple, nested
  TypoScript templates that can be moved or copied without the need to adapt all includes.

  Files within extensions can be used using :file:`FILE:EXT:my_extension/path/to/file.typoscript`.
  This should be the preferred usage, importing files not located within extensions is
  likely to be deprecated with TYPO3 v13, along with the file ending :file:`.txt`.

* Keyword "DIR":

  Can be used instead of :typoscript:`FILE` to include multiple files at once.
  It includes all files from a directory relative to :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()`,
  including subdirectories.

  Files are included in alphabetical. Also files are included first, then directories.

  .. attention::
     :typoscript:`<INCLUDE_TYPOSCRIPT:` with :typoscript:`DIR:` and relative
     paths always assumes the web root directory as base directory.
     (Before TYPO3 v12 it was relative to the file holding the include statement.)

* Keyword "extensions":

  Only valid in combination with "DIR" to restrict inclusion to files ending with
  specified string. Multiple extensions are separated by comma.

  This includes all those files from the directory :file:`fileadmin/templates/`
  and from subdirectories, which have the file extension :file:`.typoscript`:

  .. code-block:: typoscript

      <INCLUDE_TYPOSCRIPT: source="DIR:fileadmin/templates/" extensions="typoscript">

* Keyword "condition":

  Conditions are the same as was presented in the :ref:`condition chapter <typoscript-syntax-conditions>`.
  The files or directories will be included only if the condition is met. Note this is obsolete
  with TYPO3 v12 since :typoscript:`<INCLUDE_TYPOSCRIPT:` can be placed inside a native condition
  as well, just like :typoscript:`@import`.

  .. code-block:: typoscript

      <INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/user.typoscript" condition="[frontend.user.isLoggedIn]">

      # Identical to:
      [frontend.user.isLoggedIn]
        <INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/user.typoscript">
      [END]

      # And identical to:
      [frontend.user.isLoggedIn]
        @import 'EXT:my_extension/Configuration/TypoScript/user.typoscript'
      [END]
