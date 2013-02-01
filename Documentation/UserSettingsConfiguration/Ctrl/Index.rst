.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _user-settings-ctrl:

['ctrl'] section
^^^^^^^^^^^^^^^^

Just like with the :ref:`$TCA <t3tca:start>`, the [ctrl] section contains some general
options that affect the global rendering of the form.

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Data type,20: Data type
   :Description,50: Description
   :Default,10: Default


 - :Key:
         dividers2tabs
   :Data type:
         :ref:`t3tsref:data-type-int`
   :Description:
         Render user setup with or without tabs. Possible values are:

         - 0 = no tabs,

         - 1 = tabs, empty tabs are hidden

         - 2 = tabs, empty tabs are disabled
   :Default:
         1
