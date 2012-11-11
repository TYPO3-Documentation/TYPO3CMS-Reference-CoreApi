.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


$TYPO3\_USER\_SETTINGS['columns'][fieldname]
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This contains the configuration array for single fields in the user
settings. This array allows the following configurations:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key

   Datatype
         Datatype

   Description
         Description


.. container:: table-row

   Key
         type

   Datatype
         string

   Description
         Defines the type of the input field

         If type=user you need to define userFunc too.

         **Example:** ::

            'installToolEnableFile' => array(
                    'type' => 'user',
                    'label' => 'LLL:EXT:setup/mod/locallang.xml:InstallToolEnableFileButton',
                    'userFunc' => 'SC_mod_user_setup_index->renderInstallToolEnableFileButton',
                    'access' => 'admin',
            )

         Allowed values: text, password, check, select, user


.. container:: table-row

   Key
         label

   Datatype
         string

   Description
         Label for the input field


.. container:: table-row

   Key
         csh

   Datatype
         string

   Description
         CSH key for the input field


.. container:: table-row

   Key
         access

   Datatype
         string

   Description
         Access control. At the moment only a admin-check is implemented

         Allowed values: admin


.. container:: table-row

   Key
         table

   Datatype
         string

   Description
         If the user setting is saved in a DB table, this property sets the
         table. At the moment only be\_users is implemented.

         Allowed values: be\_users


.. container:: table-row

   Key
         eval

   Datatype
         string

   Description
         Evaluates a field with a given function. Currently only md5 is
         implemented, for password field.

         Allowed values: md5


.. container:: table-row

   Key
         items

   Datatype
         array

   Description
         Array of key-value pair for select items Only used by type=select.


.. container:: table-row

   Key
         itemsProcFunc

   Datatype
         string

   Description
         Defines an external method for rendering items of select-type fields.
         Contrary to what is done with the TCA you have to render the <select>
         tag too. Only used by type=select.

         Use the usual class->method syntax.


.. ###### END~OF~TABLE ######


