.. include:: /Includes.rst.txt


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
         string
   :Description:
         Defines the type of the input field

         If type=user you need to define userFunc too.

         **Example:**

         .. code-block:: php

			'startModule' => array(
				'type' => 'select',
				'itemsProcFunc' => 'TYPO3\\CMS\\Setup\\Controller\\SetupModuleController->renderStartModuleSelect',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:startModule',
				'csh' => 'startModule'
			),

         Allowed values: button, check, password, select, text, user


 - :Key:
         label
   :Data type:
         string
   :Description:
         Label for the input field, should be a pointer to a localized
         label using the :code:`LLL:` syntax.


 - :Key:
         buttonLabel
   :Data type:
         string
   :Description:
         Text of the button for type=button fields.
         Should be a pointer to a localized label using the :code:`LLL:` syntax.


 - :Key:
         csh
   :Data type:
         string
   :Description:
         CSH key for the input field


 - :Key:
         access
   :Data type:
         string
   :Description:
         Access control. At the moment only a admin-check is implemented

         Allowed values: admin


 - :Key:
         table
   :Data type:
         string
   :Description:
         If the user setting is saved in a DB table, this property sets the
         table. At the moment only "be\_users" is implemented.

         Allowed values: be\_users


 - :Key:
         eval
   :Data type:
         string
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
         items
   :Data type:
         array
   :Description:
         List of items for type=select fields. This should be a simple associative
         array with key-value pairs.


 - :Key:
         itemsProcFunc
   :Data type:
         array
   :Description:
         Defines an external method for rendering items of select-type fields.
         Contrary to what is done with the TCA you have to render the <select>
         tag too. Only used by type=select.

         Use the usual class->method syntax.


 - :Key:
         onClick
   :Data type:
         string
   :Description:
         JavaScript code added to a button's onClick attribute.
         Only used by type=button. May contain :code:`sprintf()`
         markers which will be replaced by the strings provided
         in property :code:`onClickLabels`.


 - :Key:
         onClickLabels
   :Data type:
         array
   :Description:
         List of strings used to replace the markers defined in
         :code:`onClick`. Each string should point to a localized
         label using the :code:`LLL:` syntax.
