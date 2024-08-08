..  include:: /Includes.rst.txt

..  _database-troubleshooting:

===============
Troubleshooting
===============

About database error "Row size too large"
=========================================

MySQL and MariaDB can generate a "Row size too large" error when modifying
tables with numerous columns. TYPO3 version 13 has implemented measures
to mitigate this issue in most scenarios. We refer to the changelog:
:ref:`Important: #104153 - About database error
"Row size too large" <changelog:important-104153-1718790066>`.
