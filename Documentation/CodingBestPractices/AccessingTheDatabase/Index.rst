.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _database-access:

Accessing the database
^^^^^^^^^^^^^^^^^^^^^^

The TYPO3 database should always be accessed through the use of
:code:`$GLOBALS['TYPO3_DB']`. This is the instance of the
:code:`t3lib_db` class from :code:`t3lib/class.t3lib_db.php`.

The same rule applies for accessing non-TYPO3 databases: they should
be accessed by using a different instance of the same class. Failing
this condition may corrupt the TYPO3 database or prevent access to the
TYPO3 database for the rest of the script.

