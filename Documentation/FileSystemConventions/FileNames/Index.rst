.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


File names
^^^^^^^^^^

TYPO3 requires all PHP class file names to start with class.prefix
followed by a namespace prefix, underscore character, class name,
underscore character and extension. For information on namespaces and
namespace prefix, see the next section of this document. Extension for
PHP files is always php.

Non-class files must not start with class.prefix. It is recommended to
use only PHP classes and avoid non-class files.

Classes that contain PHP interfaces must have interface.prefix.

One file can contain only one class or interface.


Unit test files
"""""""""""""""

Unit test files are located in the "tests" folder at the root of the
TYPO3 source, within a sub-structure matching the source code's
structure.

The naming conventions for the files are different than those
explained above:

#. the names are not prepended with "class."

#. "Test" is appended at the end of the name, before ".php"


Example
~~~~~~~

The unit test class file for
t3lib/db/class.t3lib\_db\_preparedstatement.phpis::

   tests/t3lib/db/t3lib_db_preparedstatementTest.php

See more about unit testing in the "Unit tests" chapter.

