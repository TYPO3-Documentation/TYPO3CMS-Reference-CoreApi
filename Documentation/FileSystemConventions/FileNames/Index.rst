.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _file-names:

File names
^^^^^^^^^^

The file name describes the functionality included in the file. It
consists of several words, written in UpperCamelCase. For example in
the :code:`frontend` system extension there is the file
:code:`ContentObject/ContentObjectRenderer.php`.

It is recommended to use only PHP classes and avoid non-class files.

Files that contain PHP interfaces must have the file name end on
"Interface", e.g. :code:`FileListEditIconHookInterface.php`.

For information on class names for user files, see the according
section of this document.

One file can contain only one class or interface.

Extension for PHP files is always :code:`php`.


Unit test files
"""""""""""""""

Unit test files are located in the ":code:`Tests/Unit/`" folder in the
according extension, within a sub-structure matching the structure in
the :code:`Classes/` folder.

The naming conventions for the files are different from those explained
above: ":code:`Test`" is appended at the end of the name, before
":code:`.php`".


Example
~~~~~~~

The unit test class file for
:code:`typo3/sysext/core/Classes/Database/PreparedStatement.php` is::

   typo3/sysext/core/Tests/Unit/Database/PreparedStatementTest.php

See more about unit testing in the "Unit tests" chapter.

