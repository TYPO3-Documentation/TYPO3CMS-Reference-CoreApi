.. include:: /Includes.rst.txt

.. index:: database, utf-8

.. _troubleshooting_database:

========
Database
========

MySQL
=====

.. _troubleshooting-character-sets:

Character Set
-------------

TYPO3 uses UTF-8 encoding, you will need to ensure that your
instance of MySQL also uses UTF-8. When installing TYPO3 for
the first time, you can select UTF-8 encoding when you create
the database for the first time. For an existing database, you
will have to set each table and column to use UTF-8.
