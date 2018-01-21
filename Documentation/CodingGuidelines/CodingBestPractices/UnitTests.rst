.. include:: ../../Includes.txt

.. _cgl-unit-tests:

Unit tests
^^^^^^^^^^


Unit test files
"""""""""""""""

Unit test files are located in the ":code:`Tests/Unit/`" folder of the
according extension, within a sub-structure matching the structure in
the :code:`Classes/` folder.

As naming convention, :code:`Test` is appended at the end of the name.
As example, the unit test class file for
:file:`typo3/sysext/core/Classes/Database/PreparedStatement.php` located
at :file:`typo3/sysext/core/Tests/Unit/Database/PreparedStatementTest.php`.


Using unit tests
""""""""""""""""

Although the coverage is far from complete, there are already quite a
lot of unit tests for the TYPO3 Core. Anytime something is changed in
the Core, all existing unit tests are run to ensure that nothing
is broken.


Adding unit tests
"""""""""""""""""

The use of unit tests is strongly encouraged. Every time a new feature
is introduced or an existing one is modified, a unit test should be
added.


Conventions for unit tests
""""""""""""""""""""""""""

Unit tests should be as concise as possible. Since the :code:`setUp()`
and :code:`tearDown()` methods always have the same responsibility,
these methods do *not* need a documentation block.

Since unit tests never return anything, they do not need an
:code:`@return` tag.

