.. include:: ../../Includes.txt


.. _unit-tests:

Unit tests
^^^^^^^^^^


Using unit tests
""""""""""""""""

Although the coverage is far from complete, there are already quite a
lot of unit tests for the TYPO3 Core. Anytime something is changed in
the Core, all existing unit tests must be run to ensure that nothing
was broken.


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

