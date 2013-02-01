.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _user-settings-columns:

['columns'] section
^^^^^^^^^^^^^^^^^^^

This contains the configuration array for single fields in the user
settings. This array allows the following configurations:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Data type,20: Data type
   :Description,60: Description


 - :Key:
         type
   :Data type:
         :ref:`t3tsref:data-type-string`
   :Description:
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


 - :Key:
         label
   :Data type:
         :ref:`t3tsref:data-type-string`
   :Description:
         Label for the input field, should be a pointer to a localized
         label using the :code:`LLL:` syntax.


 - :Key:
         csh
   :Data type:
         :ref:`t3tsref:data-type-string`
   :Description:
         CSH key for the input field


 - :Key:
         access
   :Data type:
         :ref:`t3tsref:data-type-string`
   :Description:
         Access control. At the moment only a admin-check is implemented

         Allowed values: admin


 - :Key:
         table
   :Data type:
         :ref:`t3tsref:data-type-string`
   :Description:
         If the user setting is saved in a DB table, this property sets the
         table. At the moment only "be\_users" is implemented.

         Allowed values: be\_users


 - :Key:
         eval
   :Data type:
         :ref:`t3tsref:data-type-string`
   :Description:
         Evaluates a field with a given function. Currently only "md5" is
         implemented, for password field.

         Allowed values: md5

         .. note::

            In the specific case of the password field, the "md5" value defined by default
            in the TYPO3 CMS Core is overridden to an empty string by system extension
            "saltedpasswords".


 - :Key:
         eval
   :Data type:
         array
   :Description:
         Array of key-value pair for select items Only used by type=select.


 - :Key:
         itemsProcFunc
   :Data type:
         array
   :Description:
         Defines an external method for rendering items of select-type fields.
         Contrary to what is done with the TCA you have to render the <select>
         tag too. Only used by type=select.

         Use the usual class->method syntax.

