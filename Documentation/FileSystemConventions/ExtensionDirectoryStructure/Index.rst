.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _extension-directory-structure:

Extension directory structure
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

An extension directory contains the following files and directories:


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Name
         Name

   Description
         Description


.. container:: table-row

   Name
         :code:`ext_autoload.php`

   Description
         This file contains an array. This array maps class names to file
         paths. It gets loaded by the autoloader when the autoloader is
         initialized.


.. container:: table-row

   Name
         :code:`ext_emconf.php`

   Description
         This is the only mandatory file in the extension. It describes
         the extension for the rest of TYPO3.


.. container:: table-row

   Name
         :code:`ext_icon.gif` or :code:`ext_icon.png`

   Description
         This is the icon of the extension. The filename may not be changed.


.. container:: table-row

   Name
         :code:`ext_localconf.php`

   Description
         This file contains hook definitions and plugin configuration. It must
         not contain a PHP encoding declaration. The filename may not be
         changed.


.. container:: table-row

   Name
         :code:`ext_tables.php`

   Description
         This file contains table declarations. It must not contain a PHP
         encoding declaration. For more information about table declarations
         and definitions see the "TYPO3 Core API" document. The filename may
         not be changed.


.. container:: table-row

   Name
         :code:`ext_tables.sql`

   Description
         This files contains SQL definitions for extension tables. The filename
         may not be changed.

         The file may contain either a full table definition or a partial
         table. The full table definition declares extension's tables. It looks
         like a normal SQL :code:`CREATE TABLE` statement.

         The partial table definition contains a list of the fields that will
         be added to an existing table. Here is an example::

            CREATE TABLE pages (
                   tx_myext_field int(11) DEFAULT '0' NOT NULL,
            );

         Notice the comma after the field. In the full table definition it will
         be an error, but in the partial table definition it is required. TYPO3
         will merge this table definition to the existing table definition when
         comparing expected and actual table definitions. Partial definitions
         can also contain indexes and other directives. They can also change
         existing table fields though that is not recommended, because it may
         create problems with the TYPO3 core and/or other extensions.

         TYPO3 parses :code:`ext_tables.sql` files. TYPO3 expects that all
         table definitions in this file look like the ones produced by the
         :code:`mysqldump` utility. Incorrect definitions may not be recognized
         by the TYPO3 SQL parser or may lead to MySQL errors, when TYPO3 tries
         to apply them.


.. container:: table-row

   Name
         :code:`locallang*.xlf`

   Description
         These files contain localizable labels in standard XLIFF format, one
         language per file. They can also appear in subdirectories, e.g. inside
         :code:`Resources/`.


.. container:: table-row

   Name
         :code:`locallang*.xml`

   Description
         These files contain localizable labels in a custom XML based format,
         possibly multiple languages per file. They can also appear in
         subdirectories. Deprecated since TYPO3 4.6; use
         :code:`locallang*.xlf` files instead.


.. container:: table-row

   Name
         :code:`tca.php`

   Description
         This file contains full table definitions for extension tables.


.. container:: table-row

   Name
         :code:`doc/`

   Description
         This directory contains the extension manual in OpenOffice format. The
         filename may not be changed.


.. container:: table-row

   Name
         :code:`doc/manual.sxw`

   Description
         This file contains the extension manual in OpenOffice 1.0 format. The
         name or format of the file may not be changed. See the extension
         "doc_template" ("Official Doc Extension Template") on typo3.org for
         more information about extension manuals. Deprecated, provide your
         manual in ReST format instead.


.. container:: table-row

   Name
         :code:`Classes/`

   Description
         Directory for the PHP files of the extension, possibly in further
         subfolders like for example :code:`Controller/`, :code:`Domain/`,
         :code:`Plugin`, :code:`Service/` or :code:`View/`.


.. container:: table-row

   Name
         :code:`Configuration/`

   Description
         Directory for configuration files, in subfolders like :code:`TCA/` or
         :code:`TSconfig/`.


.. container:: table-row

   Name
         :code:`Documentation/`

   Description
         This directory contains the extension manual in ReST format.
         :code:`Documentation/` and its subfolders may contain several ReST
         files, images and other resources.


.. container:: table-row

   Name
         :code:`Documentation/Index.rst`

   Description
         This file contains the cover page of the extension manual in ReST
         format. The name or format of the file may not be changed. You may
         include other ReST files as you like. See the
         `"Extension Template" on docs.typo3.org`_ for more information about
         structure and syntax of extension manuals.

         .. _"Extension Template" on docs.typo3.org: http://docs.typo3.org/typo3cms/ExtensionManualExample/


.. container:: table-row

   Name
         :code:`Resources/`

   Description
         Contains the subfolders :code:`Public/` and :code:`Private/`, which
         contain resources, possibly in further subfolders, e.g.
         :code:`Templates/`, :code:`CSS/`, :code:`Images/` or
         :code:`JavaScript/`.

         This is also the directory for non–TYPO3 files supplied with the
         extension. TYPO3 is licensed under GPL version 2 or any later version.
         Any non–TYPO3 code must be compatible with GPL version 2 or any later
         version.


.. container:: table-row

   Name
         :code:`Tests/`

   Description
         This directory contains tests, e.g. unit tests in the subfolder
         :code:`Unit/`.


.. ###### END~OF~TABLE ######


This directory structure is **strongly recommended**.
Extensions may create their own directories (for example, move all
language files into other directories).

For the class names in extension files see the chapter "Class names of
user files".

