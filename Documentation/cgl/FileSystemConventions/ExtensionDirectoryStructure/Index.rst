.. include:: ../../Includes.txt


.. _extension-directory-structure:

Extension directory structure
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

An extension directory can contain the following files and directories, of which
many are optional. Note that this list is incomplete. A full list is available in
:ref:`t3coreapi:extension-files-locations`.


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Name
         :code:`ext_emconf.php`

   Description
         This is the only mandatory file in the extension. It describes
         the extension for the rest of TYPO3.


.. container:: table-row

   Name
         :code:`ext_icon.png`, :code:`ext_icon.svg` or :code:`ext_icon.gif`

   Description
         This is the icon of the extension. The filename may not be changed.
         Preferred is using an SVG file.


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
         This file contains declarations of modules and backend styles. It must
         not contain a PHP encoding declaration. For more information about table
         declarations and definitions see the "TYPO3 Core API" document. The
         filename may not be changed.


.. container:: table-row

   Name
         :code:`ext_tables.sql`

   Description
         This file contains SQL definitions for extension tables. The filename
         may not be changed.

         The file may contain either a full table definition or a partial
         table. The full table definition declares tables of the extension. It
         looks like a normal SQL :code:`CREATE TABLE` statement.

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
         :code:`TSconfig/`. E.g. the subfolder :code:`TCA/` contains files
         named like :code:`tablename.php`, which return an array of the
         configuration of the according table :code:`tablename`.


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

         .. _"Extension Template" on docs.typo3.org: https://docs.typo3.org/typo3cms/ExtensionManualExample/


.. container:: table-row

   Name
         :code:`Resources/`

   Description
         Contains the subfolders :code:`Public/` and :code:`Private/`, which
         contain resources, possibly in further subfolders, e.g.
         :code:`Templates/`, :code:`CSS/`, :code:`Language/`, :code:`Images/`
         or :code:`JavaScript/`.

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

For the class names in extension files see the chapter "Namespaces and
class names of user files".

