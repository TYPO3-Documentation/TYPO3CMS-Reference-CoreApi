.. include:: /Includes.rst.txt
.. index:: TypoScript; Includes
.. _typoscript-syntax-includes:

============
File imports
============

..  deprecated:: 13.4
    The old school :typoscript:`<INCLUDE_TYPOSCRIPT:` syntax has been deprecated
    and will be removed with TYPO3 v14.0. See :ref:`typoscript-syntax-includes-migration`.

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


.. index:: TypoScript; Includes by conditions
.. _typoscript-syntax-includes-conditions:
.. _typoscript-syntax-includes-best-practices:
.. _typoscript-syntax-includes-migration:

Migration from `<INCLUDE_TYPOSCRIPT:` to `@import`
==================================================

..  important::
    :typoscript:`@import` does not support recursively including all `.typoscript`
    files from sub directories. You need to list each directory with its own
    :typoscript:`@import` statement.
    See :ref:`typoscript-syntax-includes-migration-recursive`.

..  important::
    :typoscript:`@import` supports the file endings `.typoscript` and `.tsconfig`
    only. All other file names will be ignored. Rename all TypoScript files to
    these endings.

Most usages of :typoscript:`<INCLUDE_TYPOSCRIPT:` can be turned into :typoscript:`@import`
easily. A few examples:

..  code-block:: diff

    -<INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/myMenu.typoscript">
    +@import 'EXT:my_extension/Configuration/TypoScript/myMenu.typoscript'

     # Including .typoscript files in a single (non recursive!) directory
    -<INCLUDE_TYPOSCRIPT: source="DIR:EXT:my_extension/Configuration/TypoScript/" extensions="typoscript">
    +@import 'EXT:my_extension/Configuration/TypoScript/*.typoscript'

    # Including .typoscript and .ts files in a single (non recursive!) directory
    -<INCLUDE_TYPOSCRIPT: source="DIR:EXT:my_extension/Configuration/TypoScript/" extensions="typoscript,ts">
    +@import 'EXT:my_extension/Configuration/TypoScript/*.typoscript'
     # Rename all files ending from .ts to .typoscript

     # Including a file conditionally
    -<INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/user.typoscript" condition="[frontend.user.isLoggedIn]">
    +[frontend.user.isLoggedIn]
    +    @import 'EXT:my_extension/Configuration/TypoScript/user.typoscript'
    +[END]

There are a few more use cases that cannot be transitioned so easily since
:typoscript:`@import` is a bit more restrictive.

As one restriction :typoscript:`@import` cannot include files from arbitrary directories
like :file:`fileadmin/`, but only from extensions by using the :typoscript:`EXT:`
prefix. Instances that use :typoscript:`<INCLUDE_TYPOSCRIPT:` with :typoscript:`source="FILE:./someDirectory/..."`
should move this TypoScript into a project or site extension. Such instances are also encouraged to
look into the TYPO3 v13 :ref:`Site sets <site-sets>` feature and eventually transition towards it along the way.

:typoscript:`@import` allows to import files with the file ending `.typoscript`
and `.tsconfig`. If you used any of the outdated file endings like `.ts` or
`.txt` rename those files before switching to the :typoscript:`@import` syntax.

.. _typoscript-syntax-includes-migration-recursive:

Migrating recursive TypoScript file inclusion
---------------------------------------------

If you have such a tree of TypoScript files:

..  directory-tree::
    :show-file-icons: true

    *   EXT:my_sitepackage/Configuration/TypoScript/

        *   Setup

            *   Extensions

                *   Solr

                    *   indexing.typoscript
                    *   searchPlugin.typoscript

                *   news.typoscript
                *   tt_address.typoscript

            *   ContentElements

                *   file1.typoscript
                *   file2.typoscript
                *   file3.typoscript

            *   myProject.typoscript
            *   someSettings.typoscript

        *   setup.typoscript

Each directory **must** be listed separately for inclusion when migrating to
the `@import` statement:

..  code-block:: diff
    :caption: EXT:my_sitepackage/Configuration/TypoScript/setup.typoscript (Difference)

    -<INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_sitepackage/Configuration/TypoScript/Setup">

    +@import 'EXT:my_sitepackage/Configuration/TypoScript/Setup'
    +@import 'EXT:my_sitepackage/Configuration/TypoScript/Extensions'
    +@import 'EXT:my_sitepackage/Configuration/TypoScript/Extensions/Solr'
    +@import 'EXT:my_sitepackage/Configuration/TypoScript/ContentElements'

The need for recursive includes may also be mitigated by restructuring
TypoScript based functionality using :ref:`Site sets <t3coreapi:site-sets>`.
