.. include:: /Includes.rst.txt

.. _troubleshooting-system_modules:

==============
System Modules
==============

The following system modules can help when trying to troubleshoot issues with
TYPO3. Administrative rights are required.

.. _troubleshooting-system-modules-log:

Log
===

The TYPO3 CMS backend logs a number of actions performed by backend users:
login, cache clearing, database entries (creation, update, deletion),
settings changes, file actions and errors. A number of filters are
available to help filter this data.

.. _troubleshooting-system-modules-dbcheck:

DB Check
========

.. important::

   "DB Check and :ref:`troubleshooting-system-modules-configuration` are only available
   if the system extension "lowlevel" is installed and activated.

   To install this system extension:

   .. code-block:: bash
      :caption: ~$

      composer req typo3/cms-lowlevel


The *Database (DB) Check* module provides four functions related
to the database and its content.

Record Statistics
  Shows a count of the various records in the database,
  broken down by type for pages and content elements.

Relations
  Checks if certain relations are empty or broken, typically
  used to check if files are being referenced.

Search
  A tool to search through the whole database. It offers an
  advanced mode which is similar to a visual query builder.

Check and update global reference index
  TYPO3 CMS keeps a record of relations between all records.
  This may get out of sync when certain operations are performed
  without the strict context of the backend. It is therefore
  useful to update this index regularly.


.. _troubleshooting-system-modules-configuration:

Configuration
=============

The *Configuration* module can be used to view the various
configuration arrays used by the CMS.

.. _troubleshooting-system-modules-reports:

Reports
=======

The *Reports* module contains information and diagnostic data
about your TYPO3 CMS installation. It is recommended that you
regularly check the "Status Report" as it will inform you
about configuration errors, security issues, etc.
