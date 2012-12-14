.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


$PAGES\_TYPES
^^^^^^^^^^^^^

$PAGES\_TYPES defines the various types of pages (field: doktype) the
system can handle and what restrictions may apply to them. Here you
can set the icon and especially you can define which tables are
allowed on a certain page type (doktype).

**NOTE:** The "default" entry in the $PAGES\_TYPES-array is the "base"
for all types, and for every type the entries simply overrides the
entries in the "default" type!!

This is the default array as set in t3lib/stddb/tables.php::

   $PAGES_TYPES = array(
           '254' => array(              //  Doktype 254 is a 'Folder' - a general purpose storage folder
                   'type' => 'sys',
                   'icon' => 'sysf.gif',
                   'allowedTables' => '*'
           ),
           '255' => array(              // Doktype 255 is a recycle-bin.
                   'type' => 'sys',
                   'icon' => 'recycler.gif',
                   'allowedTables' => '*'
           ),
           'default' => array(
                   'type' => 'web',
                   'icon' => 'pages.gif',
                   'allowedTables' => 'pages',
                   'onlyAllowedTables' => '0'
           )
   );

Each array has the following options available:


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key

   Description
         Description


.. container:: table-row

   Key
         type

   Description
         Can be "sys" or "web"


.. container:: table-row

   Key
         icon

   Description
         Alternative icon.

         The file reference is on the same format "iconfile" in [ctrl] section
         of TCA


.. container:: table-row

   Key
         allowedTables

   Description
         The tables that may reside on pages with that "doktype".

         Comma-separated list of tables allowed on this page doktype. "\*" =
         all


.. container:: table-row

   Key
         onlyAllowedTables

   Description
         Boolean. If set, the tce\_main class will not allow a shift of doktype
         if unallowed records are on the page.


.. ###### END~OF~TABLE ######


**Notice:**  *All four options* must be set for the default type while
the rest can choose as they like.


