

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Accessing the database
^^^^^^^^^^^^^^^^^^^^^^

The TYPO3 database should be always accessed through the use of
$GLOBALS['TYPO3\_DB']. This is the instance of t3lib\_dbclass from
t3lib/class.t3lib\_db.php.

The same rule applies for accessing non-TYPO3 databases: they should
be accessed by using a different instance of the same class. Failing
this condition may corrupt TYPO3 database or prevent access to TYPO3
database for the rest of the script.

