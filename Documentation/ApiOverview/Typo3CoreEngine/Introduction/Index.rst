.. include:: /Includes.rst.txt
.. _tce-introduction:

============
Introduction
============


.. index::
   pair: TYPO3 Core engine; Database
   pair: TYPO3 Core engine; TCA
.. _tce-database:

Database
========

The TYPO3 Core engine is the class that handles *all* ***data***
*writing to database tables configured in $TCA*. In addition the
class handles **commands** such as copy, move, delete. It will handle
undo/history and versioning of records and everything will be logged
to the sys\_log. And it will make sure that write permissions are
evaluated correctly for the user trying to write to the database.
Generally, any processing specific option in the $TCA array is handled
by TCE.

Using TCE for manipulation of the database content in the $TCA-configured
tables guarantees that the data integrity of TYPO3 is
respected. This cannot be safely guaranteed if you write to $TCA-configured
database tables directly. It will also manage the relations
to files and other records.

TCE requires a backend login to work. This is due to the fact that
permissions are observed (of course) and thus TCE needs a backend user
to evaluate against. This means you cannot use DataHandler from the
frontend scope. Thus writing to tables (such as a guestbook) will have
to be done from the frontend *without* DataHandler.

The features of the $TCA are described in the :doc:`TCA Reference <t3tca:Index>`.


.. index:: pair: TYPO3 Core engine; Files
.. _tce-files:

Files
=====

TCE also has a part for handling files. The file operations are
normally performed in the **FILE > Filelist** module where you can manage a
directory on the server by copying, moving, deleting and editing files
and directories. The file operations are managed by two Core classes,
:php:`\TYPO3\CMS\Core\Utility\File\BasicFileUtility` and
:php:`\TYPO3\CMS\Core\Utility\File\ExtendedFileUtility`.

