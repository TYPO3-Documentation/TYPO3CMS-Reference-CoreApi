

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


$TYPO3\_USER\_SETTINGS['ctrl']
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Just like with the $TCA, the “ctrl” section contains some general
options that affect the global rendering of the form.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key
   
   Datatype
         Datatype
   
   Description
         Description
   
   Default
         Default


.. container:: table-row

   Key
         dividers2tabs
   
   Datatype
         int
   
   Description
         Render user setup with or without tabs. Possible values are:
         
         - 0 = no tabs,
         
         - 1 = tabs, empty tabs are hidden
         
         - 2 = tabs, empty tabs are disabled
   
   Default
         1


.. ###### END~OF~TABLE ######

